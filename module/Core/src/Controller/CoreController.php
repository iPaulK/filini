<?php

namespace Core\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Core\Entity\{
    Category, OurWorkCategory
};
use Core\Traits\{
    DoctrineBasicsTrait, PaginatorTrait
};

class CoreController extends AbstractActionController
{
    use DoctrineBasicsTrait;
    use PaginatorTrait;

    /** @var array */
    protected $activeCategories;

    /** @var array */
    protected $ourWorkCategories;

    /**
     * Execute the request
     *
     * @param  MvcEvent $e
     * @return mixed
     * @throws \Exception|\DomainException
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
            $controller->layout()
                ->setVariable('categories', $this->getActiveCategories())
                ->setVariable('ourWorkCategories', $this->getOurWorkCategories());
        }
    }

    public function __construct($entityManager) 
    {
        $this->entityManager = $entityManager;
    }

    protected function getActiveCategories()
    {
        if ($this->activeCategories === null) {
            $query = $this->getRepository(Category::class)->getActive();
            $this->activeCategories = $query->getResult();
        }

        return $this->activeCategories;
    }

    protected function getOurWorkCategories()
    {
        if ($this->ourWorkCategories === null) {
            $query = $this->getRepository(OurWorkCategory::class)->getActive();
            $this->ourWorkCategories = $query->getResult();
        }

        return $this->ourWorkCategories;
    }
}
