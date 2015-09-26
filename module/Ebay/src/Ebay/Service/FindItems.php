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
                $itemFilter->value[] = $listingType;
            }

            $request->itemFilter[] = $itemFilter;
        }

        // set min/max price range
        $min[] = !empty($data['minPrice']) ? $data['minPrice'] : '0.01';
        $max[] = !empty($data['maxPrice']) ? $data['maxPrice'] : '9999999.00';

        $request->itemFilter[] = new TypesFinding\ItemFilter([
            'name'  => 'MinPrice',
            'value' => $min
        ]);
        $request->itemFilter[] = new TypesFinding\ItemFilter([
            'name'  => 'MaxPrice',
            'value' => $max
        ]);

        // set sort order
        $request->sortOrder = $data['sortOrder'];

        // limit the results
        $request->paginationInput = new TypesFinding\PaginationInput();
        $request->paginationInput->entriesPerPage = (int)$data['entriesPerPage'];
        $request->paginationInput->pageNumber     = 1;

        $response = $service->findItemsAdvanced($request);

        if (isset($response->errorMessage)) {
            return $response->errorMessage->error;
        }

        // send the request
        $limit  = $data['returnsPageNumbers'];
        $result = [];

        for ($pageNum = 1; $pageNum <= $limit; $pageNum++) {
            $request->paginationInput->pageNumber = $pageNum;
//            $response = $service->findItemsAdvanced($request);

            if ($response->ack !== 'Failure') {
                foreach ($response->searchResult->item as $item) {
                    $result[] = [
                        'itemId'      => $item->itemId,
                        'title'       => $item->title,
                        'price'       => $item->sellingStatus->currentPrice->currencyId . ' '. $item->sellingStatus->currentPrice->value, // USD 10.01
                        'startTime'   => $item->listingInfo->startTime->format('Y-m-d'),
                        'endTime'     => $item->listingInfo->endTime->format('Y-m-d'),
                        'listingType' => $item->listingInfo->listingType,
                    ];
                }
            }
        }

        return $result;
    }        
}