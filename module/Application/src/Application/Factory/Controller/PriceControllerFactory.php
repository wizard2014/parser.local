<?php

namespace Application\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Application\Controller\PriceController;
use Utility\Mapper\SubscriptionPlan as SubscriptionPlanMapper;

class PriceControllerFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return PriceController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm = $serviceLocator->getServiceLocator();
        $em = $sm->get(\Doctrine\ORM\EntityManager::class);

        return new PriceController(
            new SubscriptionPlanMapper($em)
        );
    }
}
