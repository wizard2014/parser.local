<?php

/**
 * Global navigation config
 */
$base = [
    [
        'label' => 'Home',
        'route' => 'home',
    ], [
        'label' => 'Get started',
        'route' => 'get-started',
    ], [
        'label' => 'Price',
        'route' => 'price',
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
        // sub menu added here
    ],
];

$last = count($base) - 1;

// guest dropdown
$base[$last]['pages'] = [
    [
        'label'               => 'Sign up',
        'route'               => 'zfcuser/register',
        'class'               => 'dropdown-toggle',
        'pagesContainerClass' => 'dropdown-menu',
    ], [
        'label'               => 'Sing in',
        'route'               => 'zfcuser/login',
        'class'               => 'dropdown-toggle',
        'pagesContainerClass' => 'dropdown-menu',
    ],
];
$guestDropdown = $base;

// user dropdown
$base[$last]['pages'] = [
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
];
$userDropdown = $base;

return [
    'navigation' => [
        'default' => $guestDropdown,
        'user'    => $userDropdown,
    ],

    'service_manager' => [
        'abstract_factories' => [
            Zend\Navigation\Service\NavigationAbstractServiceFactory::class
        ],
    ],
];
