<?php

namespace Utility\Factory\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Utility\Service\AttributeService;
use Utility\Mapper\AttributeMapper;
use Utility\Mapper\AttributeValueMapper;

class AttributeServiceFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return AttributeService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $em = $serviceLocator->get(\Doctrine\ORM\EntityManager::class);

        return new AttributeService(
            new AttributeMapper($em),
            new AttributeValueMapper($em)
        );
    }
}
