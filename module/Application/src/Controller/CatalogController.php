<?php

namespace Application\Controller;

use Core\Controller\CoreController;
use Zend\View\Model\ViewModel;

class CatalogController extends CoreController
{
    public function indexAction(): ViewModel
    {
        return new ViewModel();
    }
}
