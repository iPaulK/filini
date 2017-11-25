<?php

namespace Core;

use Zend\ServiceManager\Factory\InvokableFactory;

return [
	'controllers' => [
        'factories' => [
            Controller\CoreController::class => InvokableFactory::class,
        ],
    ],
];
