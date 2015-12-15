<?php

namespace Utility\Factory\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Utility\Service\DataSourceService;
use Utility\Mapper\DataSourceKeyMapper;
use Utility\Mapper\DataSourceGlobalMapper;
use Utility\Mapper\DataSourceRegionalMapper;

class DataSourceServiceFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return DataSourceService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $em = $serviceLocator->get(\Doctrine\ORM\EntityManager::class);

        return new DataSourceService(
            new DataSourceKeyMapper($em),
            new DataSourceGlobalMapper($em),
            new DataSourceRegionalMapper($em)
        );
    }
}
