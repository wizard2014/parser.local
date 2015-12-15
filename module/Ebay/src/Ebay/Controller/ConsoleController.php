<?php

namespace Ebay\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Request as ConsoleRequest;
use Ebay\Service\CategoryService;
use Utility\Service\DataSourceService;

class ConsoleController extends AbstractActionController
{
    /**
     * @var CategoryService
     */
    protected $categoryService;

    /**
     * @var DataSourceService
     */
    protected $dataSourceService;

    public function __construct(
        CategoryService     $categoryService,
        DataSourceService   $dataSourceService
    ) {
        $this->categoryService   = $categoryService;
        $this->dataSourceService = $dataSourceService;
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

        // get en regions
        $regions = $this->dataSourceService->getRegions('ebay');

        // Set eBay category into db
        if (!empty($regions)) {
            $this->setEbayCategory($regions);
        }

        return 'done';
    }

    /**
     * Set eBay category
     *
     * @param $regions
     */
    protected function setEbayCategory($regions)
    {
        // list of all categories
        $currentCategories = $this->categoryService->getCurrentCategoriesId();

        foreach ($regions as $region) {
            $ebaySiteId = $this->categoryService->getEbaySiteId($region);

            $categories = $this->categoryService->getCategoryList($ebaySiteId);

            foreach ($categories as $category) {
                $newCategory = [];
                $newCategory['categoryId']          = $category->CategoryID;
                $newCategory['categoryParentId']    = $category->CategoryParentID[0];
                $newCategory['categoryLevel']       = $category->CategoryLevel;
                $newCategory['categoryName']        = $category->CategoryName;
                $newCategory['dataSourceRegional']  = $region;

                $this->categoryService->add($newCategory, $currentCategories);
            }
        }

        $this->categoryService->save();
    }
}
