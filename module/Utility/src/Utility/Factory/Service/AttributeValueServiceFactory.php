<?php

namespace Utility\Factory\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Utility\Service\AttributeValueService;
use Utility\Mapper\AttributeMapper;
use Utility\Mapper\AttributeValueMapper;

class AttributeValueServiceFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return AttributeValueService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $em = $serviceLocator->get(\Doctrine\ORM\EntityManager::class);

        return new AttributeValueService(
            new AttributeMapper($em),
            new AttributeValueMapper($em)
        );
    }
}
