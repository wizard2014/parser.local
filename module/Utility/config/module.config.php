<?php

namespace Utility;

return [
    'service_manager'=> [
        'factories' => [
            Service\DataSourceService::class        => Factory\Service\DataSourceServiceFactory::class,
            Service\SubscriptionService::class      => Factory\Service\SubscriptionServiceFactory::class,
            Service\AttributeService::class         => Factory\Service\AttributeServiceFactory::class,
        ],
    ],
    'doctrine' => [
        'driver' => [
            'utility_entity' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Utility/Entity'],
            ],
            'orm_default' => [
                'drivers' => [
                    'Utility\Entity' => 'utility_entity',
                ],
            ],
        ],
    ],
    'zfctwig' => [
        'extensions' => [
            Extension\Instance::class,
            Extension\Md5::class,
            \Twig_Extension_Debug::class,
        ],
        'environment_options' => [
            'debug' => true
        ],
    ],
    'view_helpers' => [
        'invokables' => [
            'CustomMenu' => View\Helper\CustomMenu::class,
        ],
    ],
];
