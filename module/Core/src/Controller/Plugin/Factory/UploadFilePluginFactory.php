<?php

namespace Core\Controller\Plugin\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Core\Controller\Plugin\UploadFilePlugin;

class UploadFilePluginFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container, 
        $requestedName,
        array $options = null
    ) {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $serviceManager = $container->get('ServiceManager');
        
        return new UploadFilePlugin($entityManager, $serviceManager);
    }
}
