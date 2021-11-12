<?php
namespace Project;

use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    
    // The following section is new and should be added to your file:
    'router' => [
        'routes' => [
            'project' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/project[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
//             'profile' => [
//                 'type'    => Segment::class,
//                 'options' => [
//                     'route' => '/user/profile[/:action[/:id]]',
//                     'constraints' => [
//                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
//                         'id'     => '[0-9]+',
//                     ],
//                     'defaults' => [
//                         'controller' => Controller\ProfileController::class,
//                         'action'     => 'index',
//                     ],
//                 ],
//             ],
        ],
    ],
    
    'view_manager' => [
        'template_path_stack' => [
            'project' => __DIR__ . '/../view',
        ],
    ],
];