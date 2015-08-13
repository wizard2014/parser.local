<?php

namespace Ebay\Controller;

ini_set('max_execution_time', 120);

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Request as ConsoleRequest;

use DTS\eBaySDK\Constants;
use DTS\eBaySDK\Trading\Services;
use DTS\eBaySDK\Trading\Types;

class ConsoleController extends AbstractActionController
{
    protected $mapper;
    protected $options;

    public function __construct($mapper, $options)
    {
        $this->mapper  = $mapper;
        $this->options = $options;
    }

    public function indexAction()
    {
        $service = new Services\TradingService([
            'apiVersion' => '933',
            'siteId'     => Constants\SiteIds::US
        ]);

        $request = new Types\GetCategoriesRequestType();
        $request->RequesterCredentials = new Types\CustomSecurityHeaderType();
        $request->RequesterCredentials->eBayAuthToken = '';

        $request->DetailLevel = ['ReturnAll'];

        $request->OutputSelector = [
            'CategoryArray.Category.CategoryID',
            'CategoryArray.Category.CategoryParentID',
            'CategoryArray.Category.CategoryLevel',
            'CategoryArray.Category.CategoryName'
        ];

        $response = $service->getCategories($request);

        if ($response->Ack !== 'Success') {
            if (isset($response->Errors)) {
                foreach ($response->Errors as $error) {
                    printf("Error: %s\n", $error->ShortMessage);
                }
            }
        } else {
            /**
                $batchSize = 20;

                foreach ($items as $i => $item) {
                    $product = new Product($item['datas']);

                    $em->persist($product);

                    // flush everything to the database every 20 inserts
                    if (($i % $batchSize) == 0) {
                        $em->flush();
                        $em->clear();
                    }
                }

                // flush the remaining objects
                $em->flush();
                $em->clear();
             *
             */

            $batchSize = 100;
            $i = 0;

            foreach ($response->CategoryArray->Category as $category) {
//                printf("Level %s : %s (%s) : Parent ID %s\n",
//                    $category->CategoryLevel,
//                    $category->CategoryName,
//                    $category->CategoryID,
//                    $category->CategoryParentID[0]
//                );

                if ($i > $batchSize) {
                    break;
                }

                $categoryItem = new \Ebay\Entity\StructureCategoryEbay();
                $categoryItem
                    ->setCategoryLevel($category->CategoryLevel)
                    ->setCategoryName($category->CategoryName)
                    ->setCategoryId($category->CategoryID)
                    ->setCategoryParentId($category->CategoryParentID[0]);

                $this->mapper->persist($categoryItem);

                $i++;
            }

            $this->mapper->flush();
        }

        exit;
    }
}
