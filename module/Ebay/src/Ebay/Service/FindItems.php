<?php

namespace Ebay\Service;

use DTS\eBaySDK\Constants;
use DTS\eBaySDK\Finding\Services as FindingServices;
use DTS\eBaySDK\Finding\Types as TypesFinding;
use DTS\eBaySDK\Finding\Enums as EnumsFinding;

class FindItems
{
    protected $options;

    /**
     * @param $options
     */
    public function __construct($options)
    {
        $this->options = $options;
    }

    public function findItems(array $data)
    {
        // create Finding service API
        $service = new FindingServices\FindingService([
            'appId'      => $this->options->getAppId(),
            'apiVersion' => $this->options->getFindingApiVersion(),
            'globalId'   => $data['region'] ?: 'EBAY-US'
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
        $request->paginationInput->entriesPerPage = (int)$data['entriesPerPage'];
        $request->paginationInput->pageNumber     = 1;

        $response = $service->findItemsAdvanced($request);

        if (isset($response->errorMessage)) {
            return $response->errorMessage->error;
        }

        // send the request
        $limit  = (int)$data['returnsPageNumbers'];
        $result = [];

        for ($pageNum = 1; $pageNum <= $limit; $pageNum++) {
            $request->paginationInput->pageNumber = $pageNum;
//            $response = $service->findItemsAdvanced($request);

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

                        'country'                       => $item->country,
                        'autoPay'                       => $item->autoPay ? 'Yes': 'No',
                        'pricingTreatment'              => $item->discountPriceInfo->pricingTreatment,
                        'originalRetailPrice'           => $item->discountPriceInfo->originalRetailPrice->currencyId . ' ' . $item->discountPriceInfo->originalRetailPrice->value,
                        'multiVariationListing'         => $item->isMultiVariationListing ? 'Yes' : 'No',
                        'location'                      => $item->location,
                        'paymentMethod'                 => $item->paymentMethod->current(), // only first method
                        'postalCode'                    => $item->postalCode,
                        'productId'                     => $item->productId->type . ' ' . $item->productId->value,
                        'returnsAccepted'               => $item->returnsAccepted ? 'Yes' : 'No',

                        'sellerFeedbackRatingStar'      => $item->sellerInfo->feedbackRatingStar,
                        'sellerFeedbackScore'           => $item->sellerInfo->feedbackScore,
                        'sellerPositiveFeedbackPercent' => $item->sellerInfo->positiveFeedbackPercent,
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

                        'unitPrice'                     => $item->unitPrice->type . ' ' .  $item->unitPrice->quantity,

                        'url'                           => $item->viewItemURL,
                    ];
                }
            }
        }

        return $result;
    }        
}
