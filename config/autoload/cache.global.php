<?php

return [
    'caches' => [
        'memcached' => [ //can be called directly via SM in the name of 'memcached'
              'adapter' => [
                  'name'     =>'memcached',
                  'lifetime' => 7200,
                  'options'  => [
                      'servers' => [
                          [
                              '127.0.0.1',11211
                          ]
                      ],
                      'namespace'  => 'MEMCACHED',
                      'liboptions' => [
                          'COMPRESSION'     => true,
                          'binary_protocol' => true,
                          'no_block'        => true,
                          'connect_timeout' => 100
                      ]
                  ]
              ],
              'plugins' => [
                  'exception_handler' => [
                      'throw_exceptions' => false
                  ],
              ],
        ],
        'filesystem' => [
            'adapter' => [
                'name'    =>'filesystem', // filesystem, memory, apc are working
                'options' => [
                    'ttl' => 7200
                ],
            ],
            'plugins' => [
                'exception_handler' => [
                    'throw_exceptions' => false
                ],
            ],
        ],
    ],
];
