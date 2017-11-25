<?php

namespace Application\Controller;

use Core\Controller\CoreController;
use Zend\View\Model\ViewModel;

class ProductController extends CoreController
{
    public function viewAction(): ViewModel
    {
        return new ViewModel();
    }
}
