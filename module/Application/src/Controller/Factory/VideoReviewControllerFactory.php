<?php


namespace Application\Controller\Factory;


use Application\Controller\VideoReviewController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class VideoReviewControllerFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        return new VideoReviewController($entityManager);
    }
}