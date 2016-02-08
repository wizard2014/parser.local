<?php

namespace Utility\Factory\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Utility\Service\ValidateService;
use Utility\Mapper\DataSourceKeyMapper;
use Utility\Mapper\DataSourceGlobalMapper;
use Utility\Mapper\DataSourceRegionalMapper;
use User\Mapper\SubscriptionMapper;
use Utility\Mapper\SubscriptionPlanMapper;

class ValidateServiceFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return ValidateService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $em = $serviceLocator->get(\Doctrine\ORM\EntityManager::class);

        return new ValidateService(
            new DataSourceKeyMapper($em),
            new DataSourceGlobalMapper($em),
            new DataSourceRegionalMapper($em),
            new SubscriptionMapper($em),
            new SubscriptionPlanMapper($em)
        );
    }
}
