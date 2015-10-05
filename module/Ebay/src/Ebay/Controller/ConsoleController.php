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
     * @param $categoryService
     */
    public function __construct($mapper, $categoryService)
    {
        $this->mapper = $mapper;
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

        // Check category exists
        $categoryExists = $this->mapper['category']->categoryExists();

        $this->setEbayCategory($regions);

//        if ($categoryExists) {
//            $this->updateEbayCategory($regions);
//        } else {
//            $this->setEbayCategory($regions);
//        }

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
            $propertySet = $region->getPropertySet();
            $ebaySiteId  = $propertySet['ebay_site_id'];

            $categories = $this->categoryService->getCategoryList($ebaySiteId);

            foreach ($categories as $category) {
                $categoryEntity = $this->mapper['category']->getCategoryEntity();

                $categoryItem = new $categoryEntity();
                $categoryItem->setCategoryLevel($category->CategoryLevel);
                $categoryItem->setCategoryName($category->CategoryName);
                $categoryItem->setCategoryId($category->CategoryID);
                $categoryItem->setCategoryParentId($category->CategoryParentID[0]);
                $categoryItem->setDataSourceRegional($region);

                $this->mapper['category']->persist($categoryItem);
            }

            $this->mapper['category']->flush();
        }
    }

    /**
     * Update ebay category
     *
     * @param $regions
     *
     * @todo add update categories
     */
    protected function updateEbayCategory($regions)
    {

    }
}
