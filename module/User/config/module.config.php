<?php
namespace User;

use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    
    // The following section is new and should be added to your file:
    'router' => [
        'routes' => [
            'user' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/user[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'profile' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/user/profile[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ProfileController::class,
                        'action'     => 'view',
                    ],
                ],
            ],
            'user.admin' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/user/admin[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\AdminController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'navigation' => [
        'static' => [
            [
                'label' => 'Users',
                'route' => 'user',
                'class' => 'nav-link',
                'controller' => 'user',
                'action' => 'index',
                'resource' => 'user',
                'privilege' => 'user.view.list',
            ],
            [
                'label' => 'Login',
                'route' => 'user',
                'class' => 'nav-link',
                'action' => 'login',
                'resource' => 'user',
                'privilege' => 'login.view',
            ],
            [
                'label' => 'Logout',
                'route' => 'user',
                'class' => 'nav-link',
                'action' => 'logout',
                'resource' => 'user',
                'privilege' => 'logout',
            ],
            [
                'label' => 'Register',
                'route' => 'user',
                'class' => 'nav-link',
                'action' => 'register',
                'resource' => 'user',
                'privilege' => 'register.view',
            ],
        ],
        'admin' => [
            [
                'label' => 'Admin Users',
                'route' => 'user.admin',
                'class' => 'nav-link',
                //'controller' => 'admin',
                'action' => 'index',
                'resource' => 'admin',
                'privilege' => 'admin.access',
            ],
            [
                'label' => 'Logout',
                'route' => 'user',
                'class' => 'nav-link',
                'action' => 'logout',
                'resource' => 'user',
                'privilege' => 'logout',
                'order' => 100,
            ],
        ],
        'user' => [
            [
                'label' => 'Profile',
                'route' => 'profile',
                'class' => 'nav-link',
                'action' => 'view',
                'resource' => 'user',
                'privilege' => 'view',
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'user' => __DIR__ . '/../view',
        ],
    ],
];