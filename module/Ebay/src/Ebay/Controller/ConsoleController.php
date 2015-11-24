<?php

namespace Ebay\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Request as ConsoleRequest;

use Ebay\Service\Category as CategoryService;
use Ebay\Mapper\Category as CategoryMapper;
use Utility\Mapper\DataSourceGlobal as DataSourceGlobalMapper;
use Utility\Mapper\DataSourceRegional as DataSourceRegionalMapper;

class ConsoleController extends AbstractActionController
{
    protected $mapper;
    protected $cache;
    protected $categoryService;
    protected $categoryMapper;
    protected $dataSourceGlobalMapper;
    protected $dataSourceRegionalMapper;

    public function __construct(
        CategoryService          $categoryService,
        CategoryMapper           $categoryMapper,
        DataSourceGlobalMapper   $dataSourceGlobalMapper,
        DataSourceRegionalMapper $dataSourceRegionalMapper
    ) {
        $this->categoryService = $categoryService;

        $this->categoryMapper           = $categoryMapper;
        $this->dataSourceGlobalMapper   = $dataSourceGlobalMapper;
        $this->dataSourceRegionalMapper = $dataSourceRegionalMapper;
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
        $dataSourceGlobalIdEbay = $this->dataSourceGlobalMapper->getIdByName('eBay');
        $regions = $this->dataSourceRegionalMapper->getDataByRegion($dataSourceGlobalIdEbay, 'en', 'ebay'); // ebay in english

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
        $currentCategories = $this->categoryMapper->getAllCategoriesId();

        foreach ($regions as $region) {
            $ebaySiteId = $region->getPropertySet()['ebay_site_id'];

            $categories = $this->categoryService->getCategoryList($ebaySiteId);

            foreach ($categories as $category) {
                $test = $this->filter($category->CategoryName);

                if ($test && !isset($currentCategories[$category->CategoryID])) {
                    $this->categoryMapper->setCategory(
                        $category->CategoryLevel,
                        $category->CategoryName,
                        $category->CategoryID,
                        $category->CategoryParentID[0],
                        $region
                    );
                }

            }

            $this->categoryMapper->flush();
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
