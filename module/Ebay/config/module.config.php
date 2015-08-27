<?php

return [
    'router' => [
        'routes' => [
            'ebay' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/ebay',
                    'defaults' => [
                        '__NAMESPACE__' => 'Ebay\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'default' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => [
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults' => [
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            'Ebay\Controller\Index'   => 'Ebay\Factory\Controller\IndexControllerFactory',
            'Ebay\Controller\Console' => 'Ebay\Factory\Controller\ConsoleControllerFactory',
        ],
    ],
    'service_manager'=> [
        'factories' => [
            'Ebay\Service\Category' => 'Ebay\Factory\Service\CategoryServiceFactory',
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    // Placeholder for console routes
    'console' => [
        'router' => [
            'routes' => [
                'ebay-category' => [
                    'options' => [
                        'route'    => 'ebay-category',
                        'defaults' => [
                            'controller' => 'Ebay\Controller\Console',
                            'action' => 'index'
                        ],
                    ],
                ],
            ],
        ],
    ],
    'doctrine' => [
        'driver' => [
            'ebay_entity' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Ebay/Entity'],
            ],
            'orm_default' => [
                'drivers' => [
                    'Ebay\Entity' => 'ebay_entity',
                ],
            ],
        ],
    ],
];
