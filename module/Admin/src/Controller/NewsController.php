<?php

namespace Admin\Controller;

use Core\Controller\CoreController;
use Core\Entity\News;
use Zend\View\Model\{
    ViewModel, JsonModel
};

class NewsController extends CoreController
{
    /**
     * Show list of news
     *
     * @return ViewModel
     */
    public function indexAction(): ViewModel
    {
        return new ViewModel();
    }
}
