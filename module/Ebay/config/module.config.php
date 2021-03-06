<?php

namespace Ebay;

return [
    'router' => [
        'routes' => [
            'ebay' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/ebay',
                    'defaults' => [
                        'controller' => Controller\Index::class,
                        'action'     => 'index',
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
            Controller\Index::class    => Factory\Controller\IndexControllerFactory::class,
            Controller\Console::class  => Factory\Controller\ConsoleControllerFactory::class,
            Controller\Listener::class => Factory\Controller\ListenerControllerFactory::class,
        ],
    ],
    'service_manager'=> [
        'factories' => [
            Service\CategoryService::class  => Factory\Service\CategoryServiceFactory::class,
            Service\FindItemsService::class => Factory\Service\FindItemsServiceFactory::class,
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'ebay/message' => __DIR__ . '/../view/ebay/mail/message.phtml',
        ],
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
                            'controller' => Controller\Console::class,
                            'action'     => 'index'
                        ],
                    ],
                ],
                'listener' => [
                    'options' => [
                        'route'    => 'listener',
                        'defaults' => [
                            'controller' => Controller\Listener::class,
                            'action'     => 'index'
                        ],
                    ],
                ],
            ],
        ],
    ],
    'doctrine' => [
        'eventmanager' => [
            'orm_default' => [
                'subscribers' => [
                    // listeners
                    \Gedmo\Timestampable\TimestampableListener::class,
                ],
            ],
        ],
        'driver' => [
            'ebay_entity' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
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
