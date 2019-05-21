<?php

namespace Admin\Controller\Factory;

use Admin\Controller\VideoReviewController;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class VideoReviewControllerFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    )
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        return new VideoReviewController($entityManager);
    }
}