<?php

namespace Ebay\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Ebay\Controller\IndexController;
use Ebay\Mapper\Category as CategoryMapper;
use Utility\Mapper\DataSourceGlobal as DataSourceGlobalMapper;
use Utility\Mapper\DataSourceRegional as DataSourceRegionalMapper;

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

        $em = $sm->get(\Doctrine\ORM\EntityManager::class);

        $ebayFindingService = $sm->get(\Ebay\Service\FindItems::class);

        $mapper = [
            'category'            => new CategoryMapper($em),
            'dataSourceGlobal'    => new DataSourceGlobalMapper($em),
            'dataSourceRegional'  => new DataSourceRegionalMapper($em),
        ];

        return new IndexController($ebayFindingService, $mapper);
    }
}
