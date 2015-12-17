<?php

namespace Ebay\Service;

use DTS\eBaySDK\Constants;
use DTS\eBaySDK\Trading\Services;
use DTS\eBaySDK\Trading\Types;
use Ebay\Options\ModuleOptions;
use Ebay\Mapper\CategoryMapper;

class CategoryService
{
    /**
     * @var ModuleOptions
     */
    protected $options;

    /**
     * @var CategoryMapper
     */
    protected $categoryMapper;

    /**
     * @param ModuleOptions  $options
     * @param CategoryMapper $categoryMapper
     */
    public function __construct(
        ModuleOptions            $options,
        CategoryMapper           $categoryMapper
    ) {
        $this->options          = $options;
        $this->categoryMapper   = $categoryMapper;
    }

    /**
     * @param int $region
     *
     * @return array|Types\CategoryType[]|Types\ErrorType
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

        // if error
        $error = [];
        foreach ($response->Errors as $error) {
            $error[] = $error->ShortMessage;
        }

        return $error;
    }

    /**
     * @param $category
     * @param $currentCategories
     *
     * @return bool
     */
    public function add($category, $currentCategories)
    {
        $test = $this->filter($category['categoryName']);

        if ($test && !isset($currentCategories[$category['categoryId']])) {
            $this->categoryMapper->add($category);

            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function save()
    {
        return $this->categoryMapper->save();
    }

    /**
     * @return array
     */
    public function getCurrentCategoriesId()
    {
        return $this->categoryMapper->getAllCategoriesId();
    }

    /**
     * @param $region
     *
     * @return string
     */
    public function getEbaySiteId($region)
    {
        return $region->getPropertySet()['ebay_site_id'];
    }

    /**
     * @param $dataSourceRegional
     * @param $categoryLevel
     * @param $categoryParentId
     *
     * @return array
     */
    public function getCategory($dataSourceRegional, $categoryLevel, $categoryParentId)
    {
        if (!empty($categoryParentId)) {
            $categories = $this->categoryMapper->getCategory($dataSourceRegional, $categoryLevel, $categoryParentId);
        } else {
            $categories = $this->categoryMapper->getMainCategory($dataSourceRegional, $categoryLevel);
        }

        return $categories;
    }

    /**
     * @param $categoryName
     *
     * @return bool
     */
    protected function filter($categoryName)
    {
        if (stripos($categoryName, 'unknown')           !== false
            || stripos($categoryName, 'test auctions')  !== false
            || stripos($categoryName, 'attributes')     !== false
            || stripos($categoryName, 'category')       !== false
            || preg_match('/group[\s]*[0-9]/i', $categoryName)
            || preg_match('/ebay[\s]*test/i', $categoryName)
        ) {
            return false;
        }

        return true;
    }
}
