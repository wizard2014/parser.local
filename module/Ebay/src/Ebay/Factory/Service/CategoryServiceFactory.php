<?php

namespace Ebay\Factory\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Ebay\Options\ModuleOptions;
use Ebay\Service\Category as CategoryService;

class CategoryServiceFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return CategoryService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = new ModuleOptions($serviceLocator->get('Config')['application_options']);

        return new CategoryService($options);
    }
}
