<?php

namespace Application\View\Helper;

use Doctrine\ORM\EntityManager;
use Zend\View\Helper\AbstractHelper;
use Zend\Authentication\AuthenticationService;
use Core\Entity\Category;
use Core\Entity\OurWorkCategory;

class Layout extends AbstractHelper
{
    /**
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * @var array
     */
    private $activeCategories;

    /**
     * @var array
     */
    private $ourWorkCategories;

    /**
     *
     * @param AuthenticationService $auth
     */
    public function __construct(EntityManager $em)
    {
        $this->entityManager = $em;
    }

    /**
     * @return Layout
     */
    public function __invoke()
    {
        return $this;
    }

    /**
     * @return array
     */
    public function getActiveCategories()
    {
        if ($this->activeCategories === null) {
            $query = $this->entityManager->getRepository(Category::class)->getActive();
            $this->activeCategories = $query->getResult();
        }

        return $this->activeCategories;
    }

    /**
     * @return array
     */
    public function getOurWorkCategories()
    {
        if ($this->ourWorkCategories === null) {
            $query = $this->entityManager->getRepository(OurWorkCategory::class)->getActive();
            $this->ourWorkCategories = $query->getResult();
        }

        return $this->ourWorkCategories;
    }
}