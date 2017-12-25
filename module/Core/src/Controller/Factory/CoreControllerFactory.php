<?php

namespace Core\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Core\Controller\CoreController;

class CoreControllerFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container, 
        $requestedName,
        array $options = null
    ) {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        
        return new CoreController($entityManager);
    }
}
