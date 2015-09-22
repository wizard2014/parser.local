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
        foreach ($regions as $region) {
            $ebaySiteId = $region->getPropertySet()['ebay_site_id'];

            $categories = $this->categoryService->getCategoryList($ebaySiteId);

            foreach ($categories as $category) {
                $cache = []; // cashing array

                $categoryEntity = $this->mapper['category']->getCategoryEntity();

                $categoryItem = new $categoryEntity();
                $categoryItem->setCategoryLevel($category->CategoryLevel);
                $categoryItem->setCategoryName($category->CategoryName);
                $categoryItem->setCategoryId($category->CategoryID);
                $categoryItem->setCategoryParentId($category->CategoryParentID[0]);
                $categoryItem->setDataSourceRegional($region);

                // prepare cache data
                $cache[$ebaySiteId]['level_' . $category->CategoryLevel][] = [
                    'category_id'        => $category->CategoryID,
                    'category_parent_id' => $category->CategoryParentID[0],
                    'category_name'      => $category->CategoryName,
                ];

                // add to cache
                $this->setInCache($ebaySiteId, $cache);

                $this->mapper['category']->persist($categoryItem);
            }

            $this->mapper['category']->flush();
        }
    }

    /**
     * Set Category list in cache
     *
     * @param $categoryKey
     * @param $cacheData
     */
    protected function setInCache($categoryKey, $cacheData)
    {
        $this->cache->setItem($categoryKey, $cacheData);
    }
}
