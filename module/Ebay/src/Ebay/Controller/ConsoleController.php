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

        $categories = $this->categoryService->getCategoryList();

        /**
         * @todo fix region
         */
        $region = $this->mapper->getRegionById(0); // Ebay US
        $this->ebayGlobalId = $region->getEbayGlobalId();

        foreach ($categories as $category) {
            $categoryItem = $this->mapper->getCategoryEntity();

            $categoryItem
                ->setCategoryLevel($category->CategoryLevel)
                ->setCategoryName($category->CategoryName)
                ->setCategoryId($category->CategoryID)
                ->setCategoryParentId($category->CategoryParentID[0])
                ->setDataSourceRegional($region);

            $this->mapper->persist($categoryItem);

            $this->cacheArr[$this->ebayGlobalId][$category->CategoryLevel][] = [
                'categoryId'        => $category->CategoryID,
                'categoryParentId'  => $category->CategoryParentID[0],
                'categoryName'      => $category->CategoryName,
            ];
        }

        $this->mapper->flush();

        $this->setInCache();

        return 'done';
    }

    /**
     * Set Category list in cache
     */
    protected function setInCache()
    {
        if (!empty($this->cacheArr)) {
            $this->cache->setItem($this->ebayGlobalId, json_encode($this->cacheArr));
        }
    }
}
