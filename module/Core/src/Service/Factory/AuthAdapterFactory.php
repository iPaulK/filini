<?php
namespace Core\Service\Factory;

use Interop\Container\ContainerInterface;
use Core\Service\AuthAdapter;
use Zend\ServiceManager\Factory\FactoryInterface;

class AuthAdapterFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {        
        $entityManager = $container->get('doctrine.entitymanager.orm_default');        
        
        return new AuthAdapter($entityManager);
    }
}