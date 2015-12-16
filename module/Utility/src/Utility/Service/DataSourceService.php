<?php

namespace Utility\Service;

use Utility\Mapper\DataSourceKeyMapper;
use Utility\Mapper\DataSourceGlobalMapper;
use Utility\Mapper\DataSourceRegionalMapper;

class DataSourceService implements DataSourceServiceInterface
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
     * {@inheritdoc}
     */
    public function getRegions($vendor, $lang = 'en')
    {
        $dataSourceGlobalId = $this->dataSourceGlobalMapper->getIdByName($vendor);

        $regions = $this->dataSourceRegionalMapper->getDataByRegion($dataSourceGlobalId, $lang);

        return $regions;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilterSet($vendor)
    {
        return $this->dataSourceGlobalMapper->getSourceGlobalByName(strtolower($vendor));
    }

    /**
     * {@inheritdoc}
     */
    public function getEbayFilterSet()
    {
        return $this->getFilterSet('ebay');
    }
}
