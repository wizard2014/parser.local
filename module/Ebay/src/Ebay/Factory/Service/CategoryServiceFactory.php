<?php

namespace Ebay\Factory\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Ebay\Options\ModuleOptions;
use Ebay\Service\CategoryService;
use Ebay\Mapper\CategoryMapper;

class CategoryServiceFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return CategoryService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $em = $serviceLocator->get(\Doctrine\ORM\EntityManager::class);

        try {
            $cache = $serviceLocator->get('memcached');
        } catch(\Exception $e) {
            $cache = $serviceLocator->get('filesystem');
        }

        return new CategoryService(
            new ModuleOptions($serviceLocator->get('Config')['application_options']),
            new CategoryMapper($em),
            $cache
        );
    }
}
