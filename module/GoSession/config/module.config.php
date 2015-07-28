<?php
return [
    //Configure session manager
    'session' => [
        'config' => [
            'class' => 'Zend\Session\Config\SessionConfig',
            'options' => [
                'name' => 'parser',
                'remember_me_seconds'   => 86400,
                'use_cookies'           => true,
                'cookie_httponly'       => true,
            ],
        ],
        'storage' => 'Zend\Session\Storage\SessionArrayStorage',
        'validators' => [
            'Zend\Session\Validator\RemoteAddr',
            'Zend\Session\Validator\HttpUserAgent',
        ],
    ],
];