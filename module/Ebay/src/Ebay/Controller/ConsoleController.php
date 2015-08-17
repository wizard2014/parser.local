<?php

namespace Ebay\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Request as ConsoleRequest;

class ConsoleController extends AbstractActionController
{
    protected $mapper;
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

        $categories = $this->categoryService->getCategoryList();

        $region = $this->mapper->getRegionById(0); // Ebay US

        foreach ($categories as $category) {
            $categoryItem = $this->mapper->getCategoryEntity();

            $categoryItem
                ->setCategoryLevel($category->CategoryLevel)
                ->setCategoryName($category->CategoryName)
                ->setCategoryId($category->CategoryID)
                ->setCategoryParentId($category->CategoryParentID[0])
                ->setDataSourceRegional($region);

            $this->mapper->persist($categoryItem);
        }

        $this->mapper->flush();

        return 'done';
    }
}
