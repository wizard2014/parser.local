<?php

namespace Ebay\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Ebay\Controller\ConsoleController;
use Ebay\Mapper\Category as CategoryMapper;
use Utility\Mapper\DataSourceGlobal as DataSourceGlobalMapper;
use Utility\Mapper\DataSourceRegional as DataSourceRegionalMapper;

class ConsoleControllerFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return ConsoleController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm = $serviceLocator->getServiceLocator();
        $em = $sm->get(\Doctrine\ORM\EntityManager::class);

        $cache = $sm->get('memcached');

        $categoryService = $sm->get(\Ebay\Service\Category::class);

        $mapper = [
            'category'            => new CategoryMapper($em),
            'dataSourceGlobal'    => new DataSourceGlobalMapper($em),
            'dataSourceRegional'  => new DataSourceRegionalMapper($em),
        ];

        return new ConsoleController($mapper, $cache, $categoryService);
    }
}
