<?php

namespace Admin;

use Locale;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature;

class Module implements Feature\BootstrapListenerInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(EventInterface $e)
    {
        //Locale::setDefault('ru');
    }
}
