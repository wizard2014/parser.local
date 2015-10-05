<?php

namespace Application\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Application\Controller\GetStartedController;
use Ebay\Mapper\Category as CategoryMapper;
use Utility\Mapper\DataSourceGlobal as DataSourceGlobalMapper;
use Utility\Mapper\DataSourceRegional as DataSourceRegionalMapper;

class GetStartedControllerFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return GetStartedController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm = $serviceLocator->getServiceLocator();
        $em = $sm->get(\Doctrine\ORM\EntityManager::class);

        $cache = $sm->get('memcached');

        $mapper = [
            'category'            => new CategoryMapper($em),
            'dataSourceGlobal'    => new DataSourceGlobalMapper($em),
            'dataSourceRegional'  => new DataSourceRegionalMapper($em),
        ];

        return new GetStartedController($mapper, $cache);
    }
}
