<?php

namespace Ebay\Service;

use DTS\eBaySDK\Constants;
use DTS\eBaySDK\Trading\Services;
use DTS\eBaySDK\Trading\Types;
use Ebay\Options\ModuleOptions;
use Ebay\Mapper\CategoryMapper;

class CategoryService implements CategoryServiceInterface
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
     * @var \Zend\Cache\Storage\Adapter\Filesystem|\Zend\Cache\Storage\Adapter\Memcached
     */
    protected $cache;

    /**
     * CategoryService constructor.
     *
     * @param ModuleOptions  $options
     * @param CategoryMapper $categoryMapper
     * @param                $cache
     */
    public function __construct(
        ModuleOptions            $options,
        CategoryMapper           $categoryMapper,
                                 $cache
    ) {
        $this->options          = $options;
        $this->categoryMapper   = $categoryMapper;
        $this->cache            = $cache;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function save()
    {
        return $this->categoryMapper->save();
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentCategoriesId()
    {
        return $this->categoryMapper->getAllCategoriesId();
    }

    /**
     * {@inheritdoc}
     */
    public function getEbaySiteId($region)
    {
        return $region->getPropertySet()['ebay_site_id'];
    }

    /**
     * {@inheritdoc}
     */
    public function getCategory($dataSourceRegional, $categoryLevel, $categoryParentId)
    {
        $cacheKey = 'ebay'. $dataSourceRegional . $categoryLevel . $categoryParentId ?: 0;

        $cachedCategories = unserialize($this->cache->getItem($cacheKey));

        if ($cachedCategories) {
            // get data from cache
            $categories = unserialize($this->cache->getItem($cacheKey));
        } else {
            // get data from db
            if (!empty($categoryParentId)) {
                $categories = $this->categoryMapper->getCategory($dataSourceRegional, $categoryLevel, $categoryParentId);
            } else {
                $categories = $this->categoryMapper->getMainCategory($dataSourceRegional, $categoryLevel);
            }

            $this->cache->setItem($cacheKey, serialize($categories));
        }

        return $categories;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($data)
    {
        $categoryValid = $this->categoryMapper->categoryExists($data['region'], $data['category']);

        if ($categoryValid) {
            return '';
        }

        return 'Invalid [Category].';
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
