<?php

namespace Application\Controller\Factory;

use Application\Controller\InstallmentController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class InstallmentControllerFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        return new InstallmentController($entityManager);
    }
}