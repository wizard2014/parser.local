<?php

namespace Ebay\Service;

use DTS\eBaySDK\Constants;
use DTS\eBaySDK\Trading\Services;
use DTS\eBaySDK\Trading\Types;

class Category
{
    protected $options;

    /**
     * @param $options
     */
    public function __construct($options)
    {
        $this->options = $options;
    }

    /**
     * @param int $region
     *
     * @return Types\CategoryType[]|Types\ErrorType[]
     */
    public function getCategoryList($region = 0 /* EBAY-US */)
    {
        $service = new Services\TradingService([
            'apiVersion' => $this->options->getTradingApiVersion(),
            'siteId'     => $region
        ]);

        $request = new Types\GetCategoriesRequestType();

        $request->RequesterCredentials = new Types\CustomSecurityHeaderType();
        $request->RequesterCredentials->eBayAuthToken = $this->options->getToken();

        $request->DetailLevel = ['ReturnAll'];

        $request->OutputSelector = [
            'CategoryArray.Category.CategoryID',
            'CategoryArray.Category.CategoryParentID',
            'CategoryArray.Category.CategoryLevel',
            'CategoryArray.Category.CategoryName'
        ];

        $response = $service->getCategories($request);

        if ($response->Ack === 'Success') {
            return $response->CategoryArray->Category;
        }

        return $response->Errors;
    }
}
