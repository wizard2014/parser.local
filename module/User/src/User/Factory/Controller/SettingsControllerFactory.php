<?php

namespace User\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use User\Controller\SettingsController;

class SettingsControllerFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return SettingsController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm = $serviceLocator->getServiceLocator();

        return new SettingsController(
            $sm->get(\User\Service\UserService::class),
            $sm->get(\Utility\Service\DataSourceService::class),
            $sm->get(\Utility\Service\SubscriptionService::class),
            $sm->get(\Utility\Service\AttributeService::class)
        );
    }
}
