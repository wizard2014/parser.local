<?php

namespace Utility\Factory\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Utility\Service\SubscriptionService;
use Utility\Mapper\SubscriptionPlanMapper;
use Utility\Mapper\SubscriptionSchemeMapper;

class SubscriptionServiceFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return SubscriptionService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $em = $serviceLocator->get(\Doctrine\ORM\EntityManager::class);

        return new SubscriptionService(
            new SubscriptionPlanMapper($em),
            new SubscriptionSchemeMapper($em)
        );
    }
}
