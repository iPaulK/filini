<?php

namespace Application\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Controller\WorkController;

class WorkControllerFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container, 
        $requestedName,
        array $options = null
    ) {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        
        return new WorkController($entityManager);
    }
}
