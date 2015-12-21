<?php

namespace Ebay\Service;

interface FindItemsServiceInterface
{
    /**
     * @param array $data
     * @param null  $appId
     *
     * @return array|\DTS\eBaySDK\Finding\Types\ErrorData[]|int
     */
    public function findItems(array $data, $appId = null);
}
