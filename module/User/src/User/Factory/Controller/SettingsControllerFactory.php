<?php

namespace User\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use User\Controller\SettingsController;
use User\Mapper\UserStatus as UserStatusMapper;
use Utility\Mapper\AttributeValue as AttributeValueMapper;

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
        $em = $sm->get(\Doctrine\ORM\EntityManager::class);

        return new SettingsController(
            new UserStatusMapper($em),
            new AttributeValueMapper($em)
        );
    }
}
