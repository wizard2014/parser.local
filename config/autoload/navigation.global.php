<?php

/**
 * Global navigation config
 */
return [
    'navigation' => [
        'default' => [
            [
                'label' => 'Home',
                'route' => 'home',
            ], [
                'label' => 'Get started',
                'route' => 'get-started',
            ], [
                'label'     => '<i class="fa fa-cogs"></i> <i class="fa fa-caret-down"></i>',
                'uri'       => '#',
                'wrapClass' => 'dropdown',         // class to <li>
                'class'     => 'dropdown-toggle',  // class to <a> like usual
                'attribs'   => [
                    'data-toggle'   => 'dropdown',  // Key = Attr name, Value = Attr Value
                    'role'          => 'button',
                    'aria-haspopup' => true,
                    'aria-expanded' => false,
                ],
                'pages' => [
                    [
                        'label'               => 'Settings',
                        'route'               => 'settings',
                        'class'               => 'dropdown-toggle',
                        'pagesContainerClass' => 'dropdown-menu',
                    ], [
                        'label'               => 'Logout',
                        'route'               => 'zfcuser/logout',
                        'class'               => 'dropdown-toggle',
                        'pagesContainerClass' => 'dropdown-menu',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ],
    ],
];
