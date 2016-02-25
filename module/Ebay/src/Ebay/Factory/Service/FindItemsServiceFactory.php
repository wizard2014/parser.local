<?php

namespace Ebay\Factory\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Ebay\Options\ModuleOptions;
use Ebay\Service\FindItemsService;

class FindItemsServiceFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return FindItemsService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options            = new ModuleOptions($serviceLocator->get('Config')['application_options']);
        $mail               = $serviceLocator->get(\MtMail\Service\Mail::class);
        $userService        = $serviceLocator->get(\User\Service\UserService::class);
        $dataSourceService  = $serviceLocator->get(\Utility\Service\DataSourceService::class);

        return new FindItemsService($options, $mail, $userService, $dataSourceService);
    }
}
