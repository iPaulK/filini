<?php

namespace Application\Controller;

use Core\Controller\CoreController;
use Zend\View\Model\ViewModel;
use \Core\Entity\{OurWorkCategory, OurWork};

class WorkController extends CoreController
{
    public function listAction(): ViewModel
    {
        $slug = $this->params()->fromRoute('slug', false);
        $curentCategory = $this->getRepository(OurWorkCategory::class)->findOneBySlug($slug);

        $query = $this->getRepository(OurWorkCategory::class)->findByStatus(OurWorkCategory::STATUS_ENABLED);
        $categories = $query->getResult();
        return new ViewModel([
            'curentCategory' => $curentCategory,
            'categories' => $categories,
        ]);
        return new ViewModel();
    }

    public function viewAction(): ViewModel
    {
    	$slug = $this->params()->fromRoute('slug', false);
        $work = $this->getRepository(OurWork::class)->findOneBySlug($slug);
        if (!$work) {
            // Error condition - work not found
            $this->getResponse()->setStatusCode(404);
            return;
        }
        return new ViewModel([
            'work' => $work,
        ]);
    }
}
