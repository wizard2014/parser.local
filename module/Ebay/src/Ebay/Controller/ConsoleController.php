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
        $request->RequesterCredentials->eBayAuthToken = 'AgAAAA**AQAAAA**aAAAAA**ezyYVQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AHmIWkAZGCpwqdj6x9nY+seQ**R+kCAA**AAMAAA**YszBHWrBvcPk6CLTKipwXRbHrkSVIMxuud6yMqr7rT5Nt6HLGBNB2lPG1Nq2VQPqlcbRJU8PboY4Zim3ipHO4rNskSAV2o901+e0Md//vc1hMLGfzItvPQeaRAYHOex1jdAkFErLPvUP7eR9/VmhDKzxh24DlgrXla7qhD3gY5PZ9G1IKULzaRUtPxB/m+Rx29roBDuv1ByQkSG8OmlvFruVst5R6ob55XDEnHVa8RidVsWNyepJS5ZvfSHwVF00r0bO7U7PAv45M7sVlG4D6WAXG9yi6fLKo53EyGFFB0kTjG0Ukihatxyl7rDf5Fzzooiq44OZyPatXlEmSV5IQvGdATpQOeqh5NMr6lnAHKEs9zwCoqUXCw101XNwLkGUMj3RTPtcf2kiBXUipwPgUhIDx5pQzBMmPX34aa86VJ4GM8St8J1ACfJdS8IzTz+r+v1ttJKyncQaBFKmAfL4qpTsVd/9zGt01e+t6Q7PnSjfm+jSmX4grGxsxGH4/rAnrgcnjhe+FVL/4D98mOblCbuKExFh8gVkyWURYzypmI2etc/tmUZdsrEghnkBvwKi68VG2VCZLFfFs6pqCtpJasNR/WXNrxQCZc8h3J2VEn1Mf/9hJ5kZPnMatr1iatk7wUQpkMKFb9p2AgUjwbkJ+lslG8RR4AW72vNrljd1iwqZrznTjmqtUNbZLywKdXwnDahJvyawZ8ZUryGH9j6CRjZ6f+vHia6ihs+xJP8AXlxu61e63NJVU/BtqupdfJhd';

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
