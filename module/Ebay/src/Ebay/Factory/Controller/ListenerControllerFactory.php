<?php

namespace Ebay\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Ebay\Controller\ListenerController;

class ListenerControllerFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return ListenerController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm = $serviceLocator->getServiceLocator();

        $ebayFindingService = $sm->get(\Ebay\Service\FindItemsService::class);

        return new ListenerController($ebayFindingService);
    }
}
