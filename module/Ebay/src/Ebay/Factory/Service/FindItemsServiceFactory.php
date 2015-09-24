<?php

namespace Ebay\Factory\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Ebay\Options\ModuleOptions;
use Ebay\Service\FindItems as FindItemsService;

class FindItemsServiceFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return FindItemsService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = new ModuleOptions($serviceLocator->get('Config')['application_options']);

        return new FindItemsService($options);
    }
}
