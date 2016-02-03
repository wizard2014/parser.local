<?php

namespace User\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use User\Controller\ReSendController;

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

        $userService            = $sm->get(\User\Service\UserService::class);
        $userRegistrationMapper = $sm->get(\HtUserRegistration\UserRegistrationMapper::class);
        $mailer                 = $sm->get(\HtUserRegistration\Mailer\Mailer::class);

        return new ReSendController($userService, $userRegistrationMapper, $mailer);
    }
}
