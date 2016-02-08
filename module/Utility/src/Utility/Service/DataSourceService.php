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
    public function getRegions($vendor, $lang = 'en', $fullResult = true)
    {
        $dataSourceGlobalId = $this->dataSourceGlobalMapper->getIdByName($vendor);

        $regions = $this->dataSourceRegionalMapper->getDataByRegion($dataSourceGlobalId, $lang, $fullResult);

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

    /**
     * @param $id
     *
     * @return int|null
     */
    public function getRegionNameById($id)
    {
        return $this->dataSourceRegionalMapper->getRegionNameById($id);
    }

    /**
     * @return array
     */
    public function getVendors()
    {
        return $this->dataSourceGlobalMapper->getAllVendor();
    }

    /**
     * @param $id
     *
     * @return object
     */
    public function getSourceGlobalById($id)
    {
        return $this->dataSourceGlobalMapper->getSourceGlobalById($id);
    }

    /**
     * @param $user
     * @param $region
     *
     * @return array
     */
    public function getKey($user, $region)
    {
        return $this->dataSourceKeyMapper->getKey($user, $region);
    }

    /**
     * @param           $user
     * @param           $dataSourceGlobal
     * @param           $accessKey
     * @param bool|true $isValid
     */
    public function setKey($user, $dataSourceGlobal, $accessKey, $isValid = true)
    {
        $this->dataSourceKeyMapper->setKey($user, $dataSourceGlobal, $accessKey, $isValid);
    }

    /**
     * @param $dataSourceGlobalId
     *
     * @return string
     */
    public function getEbayGlobalId($dataSourceGlobalId)
    {
        return $this->dataSourceRegionalMapper->getPropertySet($dataSourceGlobalId, 'ebay_global_id');
    }

    /**
     * Set user invalid key
     *
     * @param $user
     * @param $dataSourceGlobalId
     */
    public function setInvalidKey($user, $dataSourceGlobalId)
    {
        $this->dataSourceKeyMapper->setInvalidKeyStatus($user, $dataSourceGlobalId);
    }

    /**
     * @param $user
     * @param $dataSourceGlobal
     *
     * @return bool
     */
    public function keyExists($user, $dataSourceGlobal)
    {
        return $this->dataSourceKeyMapper->keyExists($user, $dataSourceGlobal);
    }
}
