<?php

namespace Ebay\Service;

interface CategoryServiceInterface
{
    /**
     * @param int $region
     *
     * @return array|\DTS\eBaySDK\Trading\Types\CategoryType[]|\DTS\eBaySDK\Trading\Types\ErrorType
     */
    public function getCategoryList($region = 0 /* EBAY-US */);

    /**
     * @param $category
     * @param $currentCategories
     *
     * @return bool
     */
    public function add($category, $currentCategories);

    /**
     * @return bool
     */
    public function save();

    /**
     * @return array
     */
    public function getCurrentCategoriesId();

    /**
     * @param $region
     *
     * @return string
     */
    public function getEbaySiteId($region);

    /**
     * @param $dataSourceRegional
     * @param $categoryLevel
     * @param $categoryParentId
     *
     * @return array
     */
    public function getCategory($dataSourceRegional, $categoryLevel, $categoryParentId);

    /**
     * @param array $data
     *
     * @return bool
     */
    public function validate($data);
}
