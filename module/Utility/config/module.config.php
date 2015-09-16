<?php

return [
    'doctrine' => [
        'driver' => [
            'utility_entity' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
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
];
