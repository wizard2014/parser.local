<?php

namespace Utility\Factory\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Utility\Service\SubscriptionPlanService;
use Utility\Mapper\SubscriptionPlanMapper;

class SubscriptionPlanServiceFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return SubscriptionPlanMapper
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $em = $serviceLocator->get(\Doctrine\ORM\EntityManager::class);

        return new SubscriptionPlanService(
            new SubscriptionPlanMapper($em)
        );
    }
}
