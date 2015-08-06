<?php
return [
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
            'zfc-user/user/login'           => __DIR__ . '/../view/zfc-user/user/login.phtml',
            'scn-social-auth/user/login'    => __DIR__ . '/../view/scn-social-auth/user/login.phtml',
            'scn-social-auth/user/register' => __DIR__ . '/../view/scn-social-auth/user/register.phtml',
        ],
        'template_path_stack' => [
            'zfcuser' => __DIR__ . '/../view',
            'user'    => __DIR__ . '/../view',
        ],
    ],
];