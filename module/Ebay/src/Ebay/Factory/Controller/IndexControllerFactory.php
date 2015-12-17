<?php

namespace Ebay\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Ebay\Controller\IndexController;

class IndexControllerFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return IndexController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm = $serviceLocator->getServiceLocator();

        $categoryService    = $sm->get(\Ebay\Service\CategoryService::class);
        $ebayFindingService = $sm->get(\Ebay\Service\FindItemsService::class);
        $dataSourceService  = $sm->get(\Utility\Service\DataSourceService::class);

        return new IndexController($categoryService, $ebayFindingService, $dataSourceService);
    }
}
