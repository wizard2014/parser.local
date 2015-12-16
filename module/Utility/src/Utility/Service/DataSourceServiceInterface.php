<?php

namespace Utility\Service;

interface DataSourceServiceInterface
{
    /**
     * Get list of regions
     *
     * @param $vendor
     * @param $lang
     *
     * @return array
     */
    public function getRegions($vendor, $lang);

    /**
     * Get filters by vendor
     *
     * @param $vendor
     *
     * @return array
     */
    public function getFilterSet($vendor);

    /**
     * @return array
     */
    public function getEbayFilterSet();
}
