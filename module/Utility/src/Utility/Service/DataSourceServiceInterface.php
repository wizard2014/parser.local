<?php

namespace Utility\Service;

interface DataSourceServiceInterface
{
    /**
     * @param string        $vendor
     * @param string|array  $lang
     * @param bool          $fullResult
     *
     * @return array
     */
    public function getRegions($vendor, $lang, $fullResult);

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
