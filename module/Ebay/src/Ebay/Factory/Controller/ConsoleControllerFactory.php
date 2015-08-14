<?php

namespace Ebay\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Ebay\Controller\ConsoleController;
use Ebay\Mapper\Category as CategoryMapper;

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
        $em = $sm->get(\Doctrine\ORM\EntityManager::class);

        $categoryService = $sm->get(\Ebay\Service\Category::class);

        $mapper = new CategoryMapper($em);

        return new ConsoleController($mapper, $categoryService);
    }
}
