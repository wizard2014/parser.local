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
        $dataSourceGlobalIdEbay = $this->mapper['dataSourceGlobal']->getIdByName('eBay');
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
        $currentCategories = $this->mapper['category']->getAllCategoriesId();

        foreach ($regions as $region) {
            $ebaySiteId = $region->getPropertySet()['ebay_site_id'];

            $categories = $this->categoryService->getCategoryList($ebaySiteId);

            foreach ($categories as $category) {
                $test = $this->filter($category->CategoryName);

                if ($test && !isset($currentCategories[$category->CategoryID])) {
                    $categoryEntity = $this->mapper['category']->getCategoryEntity();

                    $categoryItem = new $categoryEntity();
                    $categoryItem->setCategoryLevel($category->CategoryLevel);
                    $categoryItem->setCategoryName($category->CategoryName);
                    $categoryItem->setCategoryId($category->CategoryID);
                    $categoryItem->setCategoryParentId($category->CategoryParentID[0]);
                    $categoryItem->setDataSourceRegional($region);

                    $this->mapper['category']->persist($categoryItem);
                }

            }

            $this->mapper['category']->flush();
        }
    }

    /**
     * @param $categoryName
     *
     * @return bool
     */
    protected function filter($categoryName)
    {
        if (stripos($categoryName, 'unknown')       !== false ||
            stripos($categoryName, 'test auctions') !== false ||
            stripos($categoryName, 'attributes')    !== false ||
            stripos($categoryName, 'category')      !== false ||
            preg_match('/group[\s]*[0-9]/i', $categoryName)   ||
            preg_match('/ebay[\s]*test/i', $categoryName)
        ) {
            return false;
        }

        return true;
    }
}
