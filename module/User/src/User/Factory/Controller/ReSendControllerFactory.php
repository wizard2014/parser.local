<?php

namespace User\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use User\Controller\ReSendController;
use User\Mapper\User as UserMapper;


class ReSendControllerFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return ReSendController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm = $serviceLocator->getServiceLocator();
        $em = $sm->get(\Doctrine\ORM\EntityManager::class);

        return new ReSendController(
            new UserMapper($em),
            $sm->get('HtUserRegistration\UserRegistrationMapper'),
            $sm->get('HtUserRegistration\Mailer\Mailer')
        );
    }
}
