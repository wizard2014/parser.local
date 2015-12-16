<?php

namespace Application\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Controller\GetStartedController;

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

        $categoryService   = $sm->get(\Ebay\Service\CategoryService::class);
        $dataSourceService = $sm->get(\Utility\Service\DataSourceService::class);

        try {
            $cache = $sm->get('memcached');
        } catch(\Exception $e) {
            $cache = $sm->get('filesystem');
        }

        return new GetStartedController($cache, $categoryService, $dataSourceService);
    }
}
