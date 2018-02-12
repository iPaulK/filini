<?php

namespace Core\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mvc\MvcEvent;
use Core\Traits\{
    DoctrineBasicsTrait, PaginatorTrait
};

class CoreController extends AbstractActionController
{
    use DoctrineBasicsTrait;
    use PaginatorTrait;

    /**
     * Execute the request
     *
     * @param  MvcEvent $e
     * @return mixed
     * @throws Exception\DomainException
     */
    public function onDispatch(MvcEvent $e)
    {
        parent::onDispatch($e);

        $controller = $e->getTarget();
        $controllerClass = get_class($controller);
        
        if ($controllerClass == 'Application\Controller\AuthController') {
            $controller->layout('layout/login');
        } else if (strpos($controllerClass, 'Admin') !== false) {
            $controller->layout('layout/admin');
        } else {
            $controller->layout('layout/layout');
        }
    }

    public function __construct($entityManager) 
    {
        $this->entityManager = $entityManager;
    }
}
