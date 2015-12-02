<?php

namespace User;

return [
    'router' => [
        'routes' => [
            'resend' => [
                'type' => 'Literal',
                'options' => [
                    'route'    => '/user/resend',
                    'defaults' => [
                        'controller' => Controller\ReSend::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'settings' => [
                'type' => 'Literal',
                'options' => [
                    'route'    => '/user/settings',
                    'defaults' => [
                        'controller' => Controller\Settings::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'default' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'    => '[/:action]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
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
            Controller\ReSend::class    => Factory\Controller\ReSendControllerFactory::class,
            Controller\Settings::class  => Factory\Controller\SettingsControllerFactory::class,
        ],
    ],

    'doctrine' => [
        'driver' => [
            // overriding zfc-user-doctrine-orm's config
            'zfcuser_entity' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/User/Entity'],
            ],

            'orm_default' => [
                'drivers' => [
                    'User\Entity' => 'zfcuser_entity',
                ],
            ],
        ],
        'entity_resolver' => [
            'orm_default' => [
                'resolvers' => [
                    \ZfcUser\Entity\UserInterface::class => Entity\User::class,
                ]
            ]
        ],
    ],

    'zfcuser' => [
        // telling ZfcUser to use our own class
        'user_entity_class'       => Entity\User::class,
        // telling ZfcUserDoctrineORM to skip the entities it defines
        'enable_default_entities' => false,
    ],

    'bjyauthorize' => [
        // Using the authentication identity provider, which basically reads the roles from the auth service's identity
        'identity_provider' => \BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider::class,

        'role_providers'        => [
            // using an object repository (entity repository) to load all roles into our ACL
            'BjyAuthorize\Provider\Role\ObjectRepositoryProvider' => [
                'object_manager'    => 'doctrine.entitymanager.orm_default',
                'role_entity_class' => Entity\Role::class,
            ],
        ],
    ],

    'view_manager' => [
        'template_map' => [
            'zfc-user/user/login'           => __DIR__ . '/../view/zfc-user/user/login.twig',
            'zfc-user/user/register'        => __DIR__ . '/../view/zfc-user/user/register.twig',

            'goalio-forgot-password/forgot/forgot'          => __DIR__ . '/../view/goalio-forgot-password/forgot/forgot.twig',
            'goalio-forgot-password/forgot/passwordchanged' => __DIR__ . '/../view/goalio-forgot-password/forgot/passwordchanged.twig',
            'goalio-forgot-password/forgot/reset'           => __DIR__ . '/../view/goalio-forgot-password/forgot/reset.twig',
            'goalio-forgot-password/forgot/sent'            => __DIR__ . '/../view/goalio-forgot-password/forgot/sent.twig',
        ],
        'template_path_stack' => [
            'zfcuser' => __DIR__ . '/../view',
            'user'    => __DIR__ . '/../view',
        ],
    ],
];