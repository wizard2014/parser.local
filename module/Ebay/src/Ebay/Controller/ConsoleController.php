<?php

namespace Ebay\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Request as ConsoleRequest;

class ConsoleController extends AbstractActionController
{
    protected $mapper;
    protected $cache;
    protected $categoryService;
    private $cacheArr     = [];
    private $ebayGlobalId = null;

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
     *
     * @todo add caching
     */
    protected function setEbayCategory($regions)
    {
        foreach ($regions as $region) {
            $ebaySiteId = $region->getPropertySet()['ebay_site_id'];

            $categories = $this->categoryService->getCategoryList($ebaySiteId);

            foreach ($categories as $category) {
                $categoryItem = $this->mapper['category']->getCategoryEntity();

                $categoryItem
                    ->setCategoryLevel($category->CategoryLevel)
                    ->setCategoryName($category->CategoryName)
                    ->setCategoryId($category->CategoryID)
                    ->setCategoryParentId($category->CategoryParentID[0])
                    ->setDataSourceRegional($region);

                $this->mapper['category']->persist($categoryItem);
            }

            $this->mapper['category']->flush();
        }
    }

    /**
     * Set Category list in cache
     */
    protected function setInCache()
    {

    }
}
