<?php

namespace Admin\Controller\Factory;

use Admin\Controller\MoneyRateController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class MoneyRateControllerFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        return new MoneyRateController($entityManager);
    }
}