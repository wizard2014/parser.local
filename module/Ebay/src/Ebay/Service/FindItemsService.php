<?php

namespace Ebay\Service;

use DTS\eBaySDK\Constants;
use DTS\eBaySDK\Finding\Services as FindingServices;
use DTS\eBaySDK\Finding\Types as TypesFinding;
use DTS\eBaySDK\Finding\Enums as EnumsFinding;
use Ebay\Options\ModuleOptions;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use MtMail\Service\Mail as MailService;
use User\Service\UserService;
use Utility\Service\DataSourceService;

class FindItemsService implements FindItemsServiceInterface
{
    /**
     * @var ModuleOptions
     */
    protected $options;

    /**
     * @var MailService
     */
    protected $mailService;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var DataSourceService
     */
    protected $dataSourceService;

    /**
     * @var AMQPStreamConnection
     */
    protected $connection;

    /**
     * @var int
     */
    private $maxItemForPage = 100;

    /**
     * FindItemsService constructor.
     *
     * @param ModuleOptions     $options
     * @param MailService       $mailService
     * @param UserService       $userService
     * @param DataSourceService $dataSourceService
     */
    public function __construct(
        ModuleOptions       $options,
        MailService         $mailService,
        UserService         $userService,
        DataSourceService   $dataSourceService
    ) {
        $this->options           = $options;
        $this->mailService       = $mailService;
        $this->userService       = $userService;
        $this->dataSourceService = $dataSourceService;

        $this->connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
    }

    /**
     * {@inheritdoc}
     */
    public function listen()
    {
        $channel = $this->connection->channel();

        $channel->queue_declare('queue', false, true, false, false);

        $channel->basic_qos(null, 1, null);

        $channel->basic_consume('queue', '', false, false, false, false, [$this, 'process']);

        while(count($channel->callbacks)) {
            $channel->wait();
        }

        $channel->close();
        $this->connection->close();
    }

    /**
     * {@inheritdoc}
     */
    public function process(AMQPMessage $msg)
    {
        // process
        $data = json_decode($msg->body, true);

        $resultData = $this->findItems($data['responseData'], $data['appId']);

        // @todo catch exception (service unavailable)
        // save into db
        try {
            $this->userService->saveFileData(
                $this->userService->getUser($data['user']),
                $this->dataSourceService->getSourceGlobalById($data['region']),
                $data['path'],
                $data['filename'],
                $resultData
            );

            // send email
            try {
                $this->sendMail($data['user']);
            } catch (\Exception $e) {
                $this->setLog('mail_error.txt', $data['user']);

                $this->sendMail($data['user']);
            }
        } catch (\Exception $e) {
            $this->setLog('get_data_error.txt', $data['user']);
        }

        $msg->delivery_info['channel']->basic_ack(
            $msg->delivery_info['delivery_tag']
        );
    }

    /**
     * {@inheritdoc}
     */
    public function findItems(array $data, $appId = null)
    {
        // create Finding service API
        $service = new FindingServices\FindingService([
            'appId'      => $appId ? $appId : $this->options->getAppId(),
            'apiVersion' => $this->options->getFindingApiVersion(),
            'globalId'   => $data['ebay_global_id'] ?: 'EBAY-US',
        ]);

        // Create the request object
        $request = new TypesFinding\FindItemsAdvancedRequest();

        // set keyword if exists
        if (!empty($data['keyword'])) {
            $request = new TypesFinding\FindItemsAdvancedRequest();
            $request->keywords = $data['keyword'];
        }

        // set category
        $request->categoryId = [$data['category']];

        // set listing type
        if (isset($data['listingType'])) {
            $itemFilter       = new TypesFinding\ItemFilter();
            $itemFilter->name = 'ListingType';

            foreach ($data['listingType'] as $listingType) {
                $itemFilter->value[] = str_replace(' ', '', $listingType);
            }

            $request->itemFilter[] = $itemFilter;
        }

        // set min/max price range
        if (!empty($data['minPrice'])) {
            $request->itemFilter[] = new TypesFinding\ItemFilter([
                'name'  => 'MinPrice',
                'value' => [$data['minPrice']],
            ]);
        }
        if (!empty($data['maxPrice'])) {
            $request->itemFilter[] = new TypesFinding\ItemFilter([
                'name'  => 'MaxPrice',
                'value' => [$data['maxPrice']],
            ]);
        }

        // set sort order
        $request->sortOrder = str_replace(' ', '', $data['sortOrder']);

        // limit the results
        $request->paginationInput = new TypesFinding\PaginationInput();
        $request->paginationInput->entriesPerPage = $this->maxItemForPage;
        $request->paginationInput->pageNumber     = 1;

        // DistanceNearest Sorts items by distance from the buyer in ascending order. The request must also include a buyerPostalCode
//        $request->buyerPostalCode = '';

        // specific params
        $request->outputSelector = [
            EnumsFinding\OutputSelectorType::C_SELLER_INFO,
            EnumsFinding\OutputSelectorType::C_STORE_INFO,
            EnumsFinding\OutputSelectorType::C_UNIT_PRICE_INFO,
//            EnumsFinding\OutputSelectorType::C_PICTUREURL_SUPER_SIZE,
        ];

        try {
            $response = $service->findItemsAdvanced($request);
        } catch (\Guzzle\Http\Exception\ServerErrorResponseException $e) {
            return $e->getResponse()->getStatusCode();
        }

        if (isset($response->errorMessage)) {
            return $response->errorMessage->error;
        }

        // send the request
        $limit  = ($data['itemsQty'] / $this->maxItemForPage);
        $result = [];

        for ($pageNum = 1; $pageNum <= $limit; $pageNum++) {
            $request->paginationInput->pageNumber = $pageNum;

            if ($response->ack !== 'Failure') {
                foreach ($response->searchResult->item as $item) {
                    $result[] = [
                        'itemId'                        => $item->itemId,
                        'title'                         => $item->title,
                        'price'                         => $item->sellingStatus->currentPrice->currencyId . ' '. $item->sellingStatus->currentPrice->value, // USD 10.01
                        'startTime'                     => $item->listingInfo->startTime->format('Y-m-d H:i:s'),
                        'endTime'                       => $item->listingInfo->endTime->format('Y-m-d H:i:s'),
                        'listingType'                   => $item->listingInfo->listingType,
                        'bestOfferEnabled'              => $item->listingInfo->bestOfferEnabled ? 'Yes' : 'No',
                        'buyItNow'                      => $item->listingInfo->buyItNowAvailable
                            ? $item->listingInfo->buyItNowPrice->currencyId . ' ' . $item->listingInfo->buyItNowPrice->value : 'No',

                        'condition'                     => $item->condition->conditionDisplayName,
                        'country'                       => $item->country,
                        'autoPay'                       => $item->autoPay ? 'Yes': 'No',
                        'originalRetailPrice'           => $item->discountPriceInfo->originalRetailPrice->currencyId . ' ' . $item->discountPriceInfo->originalRetailPrice->value,
                        'multiVariationListing'         => $item->isMultiVariationListing ? 'Yes' : 'No',
                        'location'                      => $item->location,
                        'paymentMethod'                 => $item->paymentMethod->current(), // only first value !!!
                        'postalCode'                    => $item->postalCode,
                        'productId'                     => $item->productId->type . ' ' . $item->productId->value,
                        'returnsAccepted'               => $item->returnsAccepted ? 'Yes' : 'No',

                        'sellerFeedbackRatingStar'      => $item->sellerInfo->feedbackRatingStar,
                        'sellerFeedbackScore'           => $item->sellerInfo->feedbackScore,
                        'sellerPositiveFeedbackPercent' => $item->sellerInfo->positiveFeedbackPercent . '%',
                        'sellerUserName'                => $item->sellerInfo->sellerUserName,
                        'topRatedSeller'                => $item->sellerInfo->topRatedSeller ? 'Yes' : 'No',
                        'bidCount'                      => $item->sellingStatus->bidCount,
                        'sellingState'                  => $item->sellingStatus->sellingState,

                        'shippingType'                  => $item->shippingInfo->shippingType,
                        // and more

                        'storeName'                     => $item->storeInfo->storeName,
                        'storeURL'                      => $item->storeInfo->storeURL,

                        'subtitle'                      => $item->subtitle,
                        'topRatedListing'               => $item->topRatedListing ? 'Yes' : 'No',

                        'unitPrice'                     => $item->unitPrice->quantity . ' ' . $item->unitPrice->type, // e.g. Kg 100g 10g L 100ml 10ml M M2 M3 Unit

                        'url'                           => $item->viewItemURL,
                    ];
                }
            }
        }

        return $result;
    }

    protected function sendMail($user)
    {
        $headers = [
            'to'        => $this->userService->getEmail($user),
            'from'      => 'Extrow | Ebay data <versoverteam@gmail.com>',
            'subject'   => 'Extrow. Your data',
        ];
        $message = $this->mailService->compose($headers, 'ebay/message');
        $this->mailService->send($message);
    }

    protected function setLog($filename, $userId)
    {
        file_put_contents('./data/output/' . $filename,
            '['. (new \DateTime())->format('Y-m-d h:i:s') . ']'
            . 'User ID ' . $userId
            . "\n"
        );
    }
}
