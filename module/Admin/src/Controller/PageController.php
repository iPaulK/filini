<?php

namespace Admin\Controller;

use Core\Controller\CoreController;
use Core\Entity\Page;
use Zend\View\Model\{
    ViewModel, JsonModel
};

class PageController extends CoreController
{
    /**
     * Show list of pages
     *
     * @return ViewModel
     */
    public function indexAction(): ViewModel
    {
        return new ViewModel();
    }
}
