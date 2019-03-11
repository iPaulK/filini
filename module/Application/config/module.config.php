<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'login' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/login',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action'     => 'login',
                    ],
                ],
            ],
            'logout' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/logout',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action'     => 'logout',
                    ],
                ],
            ],
            'not-authorized' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/not-authorized',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action'     => 'notAuthorized',
                    ],
                ],
            ],
            'application_contact' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/contacts',
                    'defaults' => [
                        'controller' => Controller\ContactController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application_catalog' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/catalog[/:slug]',
                    'defaults' => [
                        'controller' => Controller\CatalogController::class,
                        'action' => 'index',
                        'slug' => '[-a-z0-9]*',
                    ],
                ],
            ],
            'application_designers' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/designers',
                    'defaults' => [
                        'controller' => Controller\DesignersController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application_installment' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/installment',
                    'defaults' => [
                        'controller' => Controller\InstallmentController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application_product' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/product[/:slug]',
                    'defaults' => [
                        'controller' => Controller\ProductController::class,
                        'action'     => 'view',
                        'slug' => '[-a-z0-9]*',
                    ],
                ],
            ],
            'application_work_list' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/works[/:slug]',
                    'defaults' => [
                        'controller' => Controller\WorkController::class,
                        'action'     => 'list',
                        'slug' => '[-a-z0-9]*',
                    ],
                ],
             ],
            'application_work_view' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/work[/:slug]',
                    'defaults' => [
                        'controller' => Controller\WorkController::class,
                        'action' => 'view',
                        'slug' => '[-a-z0-9]*',
                    ],
                ],
            ],
            'send_proposal' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/send/proposal',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'sendProposal',
                    ],
                ],
            ],
        ],
    ],
    // The 'access_filter' key is used by the User module to restrict or permit
    // access to certain controller actions for unauthorized visitors.
    'access_filter' => [
        'controllers' => [
            Controller\IndexController::class => [
                ['actions' => '*', 'allow' => '*']
            ],
            Controller\AuthController::class => [
                ['actions' => '*', 'allow' => '*']
            ],
            Controller\ContactController::class => [
                ['actions' => '*', 'allow' => '*']
            ],
            Controller\CatalogController::class => [
                ['actions' => '*', 'allow' => '*']
            ],
            Controller\DesignersController::class => [
                ['actions' => '*', 'allow' => '*']
            ],
            Controller\ProductController::class => [
                ['actions' => '*', 'allow' => '*']
            ],
            Controller\WorkController::class => [
                ['actions' => '*', 'allow' => '*']
            ],
            Controller\InstallmentController::class => [
                ['actions' => '*', 'allow' => '*']
            ],
        ]
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class =>  Controller\Factory\IndexControllerFactory::class,
            Controller\ContactController::class => Controller\Factory\ContactControllerFactory::class,
            Controller\CatalogController::class => Controller\Factory\CatalogControllerFactory::class,
            Controller\InstallmentController::class => Controller\Factory\InstallmentControllerFactory::class,
            Controller\WorkController::class => Controller\Factory\WorkControllerFactory::class,
            Controller\DesignersController::class => Controller\Factory\DesignersControllerFactory::class,
            Controller\ProductController::class => Controller\Factory\ProductControllerFactory::class,
            Controller\AuthController::class => Controller\Factory\AuthControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'translator' => [
        'locale' => 'ru',
        'translation_files' => [
            [
                'type'=> 'phpArray',
                'filename' => 'module/Application/language/ru/Login.php',
                'text_domain' => 'default',
                'locale' => 'ru',
            ],
        ],
    ],
    'view_helpers' => array(
        'factories' => array(
            'layoutHelper' => 'Application\View\Helper\Factory\LayoutFactory',
        ),
    ),
];
