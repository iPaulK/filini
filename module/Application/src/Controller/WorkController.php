<?php

namespace Application\Controller;

use Core\Controller\CoreController;
use Zend\View\Model\ViewModel;

class WorkController extends CoreController
{
    public function listAction(): ViewModel
    {
        return new ViewModel();
    }

    public function viewAction(): ViewModel
    {
    	$slug = $this->params()->fromRoute('slug', false);
        $work = $this->getRepository('OurWork')->findOneBySlug($slug);
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
