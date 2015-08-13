<?php

namespace Ebay\Factory\Controller;

use Ebay\Controller\ConsoleController;
use Ebay\Mapper\ConsoleCategory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Ebay\Options\ModuleOptions;

class ConsoleControllerFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return ConsoleController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm = $serviceLocator->getServiceLocator();

        $em      = $sm->get(\Doctrine\ORM\EntityManager::class);
        $options = new ModuleOptions($sm->get('Config')['application_options']);

        $mapper = new ConsoleCategory($em);

        return new ConsoleController($mapper, $options);
    }
}
