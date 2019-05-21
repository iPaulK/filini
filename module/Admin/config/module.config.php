<?php

namespace Admin;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
	'router' => [
        'routes' => [
            'admin_home' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/admin[/]',
                    'defaults' => [
                        'controller' => Controller\DashboardController::class,
                        'action' => 'index',
                    ],
                ],
            ],
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
            'admin_money_rate' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/admin/money-rates[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\MoneyRateController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'admin_video_review' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/admin/video_review[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\VideoReviewController::class,
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
            'admin_product_conversion' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/admin/conversion[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\ConversionTypeController::class,
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
            'admin_promotions' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/admin/promotion[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\PromotionController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'admin_page' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/admin/pages[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\PageController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'admin_setting' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/admin/settings[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\SettingController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'admin_user' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/admin/users[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'admin_user_role' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/admin/roles[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\RoleController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'admin_user_permission' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/admin/permissions[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\PermissionController::class,
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
            Controller\ConversionTypeController::class => Controller\Factory\ConversionTypeControllerFactory::class,
            Controller\OurWorkController::class => Controller\Factory\OurWorkControllerFactory::class,
            Controller\OurWorkCategoryController::class => Controller\Factory\OurWorkCategoryControllerFactory::class,
            Controller\PromotionController::class => Controller\Factory\PromotionControllerFactory::class,
            Controller\PageController::class => Controller\Factory\PageControllerFactory::class,
            Controller\SettingController::class => Controller\Factory\SettingControllerFactory::class,
            Controller\UserController::class => Controller\Factory\UserControllerFactory::class,
            Controller\RoleController::class => Controller\Factory\RoleControllerFactory::class,
            Controller\PermissionController::class => Controller\Factory\PermissionControllerFactory::class,
            Controller\MoneyRateController::class => Controller\Factory\MoneyRateControllerFactory::class,
            Controller\VideoReviewController::class => Controller\Factory\VideoReviewControllerFactory::class,
        ],
    ],
    // The 'access_filter' key is used by the User module to restrict or permit
    // access to certain controller actions for unauthorized visitors.
    'access_filter' => [
        'controllers' => [
            Controller\DashboardController::class => [
                ['actions' => '*', 'allow' => '+dashboard.manage']
            ],
            Controller\ProductController::class => [
                ['actions' => '*', 'allow' => '+product.manage']
            ],
            Controller\CategoryController::class => [
                ['actions' => '*', 'allow' => '+category.manage']
            ],
            Controller\ConversionTypeController::class => [
                ['actions' => '*', 'allow' => '+category.manage']
            ],
            Controller\OurWorkController::class => [
                ['actions' => '*', 'allow' => '+ourwork.manage']
            ],
            Controller\PromotionController::class => [
                ['actions' => '*', 'allow' => '+news.manage']
            ],
            Controller\PageController::class => [
                ['actions' => '*', 'allow' => '+page.manage']
            ],
            Controller\SettingController::class => [
                ['actions' => '*', 'allow' => '+setting.manage']
            ],
            Controller\UserController::class => [
                // Give access to "index", "add", "edit", "view", "changePassword" actions to users having the "user.manage" permission.
                ['actions' => ['index', 'add', 'edit', 'view', 'changePassword'], 'allow' => '+user.manage']
            ],
            Controller\RoleController::class => [
                // Allow access to authenticated users having the "role.manage" permission.
                ['actions' => '*', 'allow' => '+role.manage']
            ],
            Controller\PermissionController::class => [
                // Allow access to authenticated users having "permission.manage" permission.
                ['actions' => '*', 'allow' => '+permission.manage']
            ],
            Controller\MoneyRateController::class => [
                // Allow access to authenticated users having "permission.manage" permission.
                ['actions' => '*', 'allow' => '+permission.manage']
            ],
            Controller\VideoReviewController::class => [
                // Allow access to authenticated users having "permission.manage" permission.
                ['actions' => '*', 'allow' => '+permission.manage']
            ],
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => ['ViewJsonStrategy'],
    ],
    'translator' => [
        'locale' => 'ru',
        'translation_files' => [
            [
                'type'=> 'phpArray',
                'filename' => 'module/Admin/language/ru/Admin.php',
                'text_domain' => 'default',
                'locale' => 'ru',
            ],
        ],
    ],

    'form_elements' => array(
        'aliases' => array(
            'conversion_type_select' => 'Admin\Form\Element\ConversionTypeSelect',
        ),
        'factories' => array(
            'Admin\Form\Element\ConversionTypeSelect' => 'Admin\Form\Element\ConversionTypeSelectFactory',
        ),
    ),
];
