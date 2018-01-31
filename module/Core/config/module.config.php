<?php
namespace Core;

return [
    'controllers' => [
        'factories' => [
            Controller\CoreController::class => Controller\Factory\CoreControllerFactory::class,
        ],
    ],
    'controller_plugins' => [
        'factories' => [
            Controller\Plugin\UploadFilePlugin::class => Controller\Plugin\Factory\UploadFilePluginFactory::class,
        ],
        'aliases' => [
            'uploader' => Controller\Plugin\UploadFilePlugin::class,
        ]
    ],
    'service_manager' => [
        'factories' => [
            \Zend\Authentication\AuthenticationService::class => Service\Factory\AuthenticationServiceFactory::class,
            Service\AuthAdapter::class => Service\Factory\AuthAdapterFactory::class,
            Service\AuthManager::class => Service\Factory\AuthManagerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => ['ViewJsonStrategy'],
    ],
];
