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

        try {
            $cache = $sm->get('memcached');
        } catch(\Exception $e) {
            $cache = $sm->get('filesystem');
        }

        return new GetStartedController(
            $cache,
            new CategoryMapper($em),
            new DataSourceGlobalMapper($em),
            new DataSourceRegionalMapper($em)
        );
    }
}
