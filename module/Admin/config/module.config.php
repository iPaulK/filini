<?php

namespace Admin;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
	'router' => [
        'routes' => [
            'admin_dashboard' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/admin/dashboard[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\DashboardController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'admin_product' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/admin/product[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\ProductController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'admin_product_category' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/admin/category[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\CategoryController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'admin_work' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/admin/work[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\OurWorkController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'admin_work_category' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/admin/work-category[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\OurWorkCategoryController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'admin_designers' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/admin/designer[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\DesignerController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\DashboardController::class => Controller\Factory\DashboardControllerFactory::class,
            Controller\ProductController::class => Controller\Factory\ProductControllerFactory::class,
            Controller\CategoryController::class => Controller\Factory\CategoryControllerFactory::class,
            Controller\OurWorkController::class => Controller\Factory\OurWorkControllerFactory::class,
            Controller\OurWorkCategoryController::class => Controller\Factory\OurWorkCategoryControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => ['ViewJsonStrategy'],
    ],
];
