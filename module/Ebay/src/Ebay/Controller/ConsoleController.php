<?php

namespace Ebay\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Request as ConsoleRequest;

class ConsoleController extends AbstractActionController
{
    protected $mapper;
    protected $cache;
    protected $categoryService;

    /**
     * @param $mapper
     * @param $cache
     * @param $categoryService
     */
    public function __construct($mapper, $cache, $categoryService)
    {
        $this->mapper = $mapper;
        $this->cache  = $cache;
        $this->categoryService = $categoryService;
    }

    /**
     * @return string
     *
     * @todo add update categories
     */
    public function indexAction()
    {
        $request = $this->getRequest();

        if (!$request instanceof ConsoleRequest) {
            throw new \RuntimeException('You can only use this action from a console!');
        }

        // Set eBay category into db
        $dataSourceGlobalIdEbay = $this->mapper['dataSourceGlobal']->getSourceGlobalByName('eBay')->getId();
        $regions = $this->mapper['dataSourceRegional']->getDataByRegion($dataSourceGlobalIdEbay, 'en', 'ebay'); // ebay in english
        $this->setEbayCategory($regions);

        return 'done';
    }

    /**
     * Set eBay category
     *
     * @param $regions
     */
    protected function setEbayCategory($regions)
    {
        $cache = [];

        foreach ($regions as $region) {
            $ebaySiteId = $region->getPropertySet()['ebay_site_id'];

            $categories = $this->categoryService->getCategoryList($ebaySiteId);

            foreach ($categories as $category) {
                $categoryEntity = $this->mapper['category']->getCategoryEntity();
                $categoryItem   = new $categoryEntity();

                $categoryItem
                    ->setCategoryLevel($category->CategoryLevel)
                    ->setCategoryName($category->CategoryName)
                    ->setCategoryId($category->CategoryID)
                    ->setCategoryParentId($category->CategoryParentID[0])
                    ->setDataSourceRegional($region);

                // prepare cache data
                $cache[$region->getPropertySet()['ebay_global_id']][] = [
                    'category_id'        => $category->CategoryID,
                    'category_parent_id' => $category->CategoryParentID[0],
                    'category_name'      => $category->CategoryName,
                    'category_level'     => $category->CategoryLevel,
                ];

                $this->mapper['category']->persist($categoryItem);
            }

            $this->mapper['category']->flush();
        }

        // add to cache
        $this->setInCache($cache, 'ebay_category');
    }

    /**
     * Set Category list in cache
     *
     * @param       $categoryKey
     * @param array $cacheData
     */
    protected function setInCache($categoryKey, array $cacheData)
    {
        $this->cache->setItem($categoryKey, json_encode($cacheData));
    }
}
