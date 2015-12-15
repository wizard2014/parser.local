<?php

namespace Utility\Service;

use Utility\Mapper\DataSourceKeyMapper;
use Utility\Mapper\DataSourceGlobalMapper;
use Utility\Mapper\DataSourceRegionalMapper;

class DataSourceService
{
    /**
     * @var DataSourceKeyMapper
     */
    protected $dataSourceKeyMapper;

    /**
     * @var DataSourceGlobalMapper
     */
    protected $dataSourceGlobalMapper;

    /**
     * @var DataSourceRegionalMapper
     */
    protected $dataSourceRegionalMapper;

    /**
     * @param DataSourceKeyMapper      $dataSourceKeyMapper
     * @param DataSourceGlobalMapper   $dataSourceGlobalMapper
     * @param DataSourceRegionalMapper $dataSourceRegionalMapper
     */
    public function __construct(
        DataSourceKeyMapper      $dataSourceKeyMapper,
        DataSourceGlobalMapper   $dataSourceGlobalMapper,
        DataSourceRegionalMapper $dataSourceRegionalMapper
    ) {
        $this->dataSourceKeyMapper      = $dataSourceKeyMapper;
        $this->dataSourceGlobalMapper   = $dataSourceGlobalMapper;
        $this->dataSourceRegionalMapper = $dataSourceRegionalMapper;
    }

    /**
     * Get list of regions
     *
     * @param $vendor
     * @param $lang
     *
     * @return array
     */
    public function getRegions($vendor, $lang = 'en')
    {
        $dataSourceGlobalId = $this->dataSourceGlobalMapper->getIdByName($vendor);

        $regions = $this->dataSourceRegionalMapper->getDataByRegion($dataSourceGlobalId, $lang);

        return $regions;
    }
}
