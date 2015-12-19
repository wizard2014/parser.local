<?php

namespace User\Factory\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use User\Service\UserService;
use User\Mapper\UserMapper;
use User\Mapper\UserStatusMapper;

class UserServiceFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return UserService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $em = $serviceLocator->get(\Doctrine\ORM\EntityManager::class);

        return new UserService(
            new UserMapper($em),
            new UserStatusMapper($em)
        );
    }
}
