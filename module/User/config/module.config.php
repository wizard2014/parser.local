<?php
return [
    'router' => [
        'routes' => [
            'resend' => [
                'type' => 'Literal',
                'options' => [
                    'route'    => '/user/resend',
                    'defaults' => [
                        'controller' => 'User\Controller\ReSend',
                        'action'     => 'index',
                    ],
                ],
            ],
            'settings' => [
                'type' => 'Literal',
                'options' => [
                    'route'    => '/user/settings',
                    'defaults' => [
                        'controller' => 'User\Controller\Settings',
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            'User\Controller\ReSend'    => 'User\Factory\Controller\ReSendControllerFactory',
            'User\Controller\Settings'  => 'User\Factory\Controller\SettingsControllerFactory',
        ],
    ],

    'doctrine' => [
        'driver' => [
            // overriding zfc-user-doctrine-orm's config
            'zfcuser_entity' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
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
                    'ZfcUser\Entity\UserInterface' => 'User\Entity\User',
                ]
            ]
        ],
    ],

    'zfcuser' => [
        // telling ZfcUser to use our own class
        'user_entity_class'       => 'User\Entity\User',
        // telling ZfcUserDoctrineORM to skip the entities it defines
        'enable_default_entities' => false,
    ],

    'bjyauthorize' => [
        // Using the authentication identity provider, which basically reads the roles from the auth service's identity
        'identity_provider' => 'BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider',

        'role_providers'        => [
            // using an object repository (entity repository) to load all roles into our ACL
            'BjyAuthorize\Provider\Role\ObjectRepositoryProvider' => [
                'object_manager'    => 'doctrine.entitymanager.orm_default',
                'role_entity_class' => 'User\Entity\Role',
            ],
        ],
    ],

    'view_manager' => [
        'template_map' => [
            'zfc-user/user/login'           => __DIR__ . '/../view/zfc-user/user/login.twig',
            'zfc-user/user/register'        => __DIR__ . '/../view/zfc-user/user/register.twig',
            'scn-social-auth/user/login'    => __DIR__ . '/../view/scn-social-auth/user/login.twig',
            'scn-social-auth/user/register' => __DIR__ . '/../view/scn-social-auth/user/register.twig',

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