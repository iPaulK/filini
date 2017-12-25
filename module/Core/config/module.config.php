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
];
