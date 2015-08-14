<?php

namespace Ebay\Controller;

ini_set('max_execution_time', 120);

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Request as ConsoleRequest;

class ConsoleController extends AbstractActionController
{
    protected $mapper;
    protected $categoryService;
    private $batchSize = 6000;

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
        $categories = $this->categoryService->getCategoryList();

        foreach ($categories as $i => $category) {
            $categoryItem = $this->mapper->getEntity();

            $categoryItem
                ->setCategoryLevel($category->CategoryLevel)
                ->setCategoryName($category->CategoryName)
                ->setCategoryId($category->CategoryID)
                ->setCategoryParentId($category->CategoryParentID[0]);

            $this->mapper->persist($categoryItem);

            if (($i % $this->batchSize) == 0) {
                $this->mapper->flush();
                $this->mapper->clear();
            }
        }

        return 'done';
    }
}
