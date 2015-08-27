<?php

namespace Ebay\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Ebay\Controller\IndexController;
use Ebay\Options\ModuleOptions;
use Ebay\Mapper\Category as CategoryMapper;

class IndexControllerFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return IndexController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm = $serviceLocator->getServiceLocator();
        $em = $sm->get(\Doctrine\ORM\EntityManager::class);

        $cache = $sm->get('memcached');

        $options = new ModuleOptions($sm->get('Config')['application_options']);

        $mapper = new CategoryMapper($em);

        return new IndexController($mapper, $cache, $options);
    }
}
