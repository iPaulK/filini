<?php

namespace Admin\Controller;

use Core\Controller\CoreController;
use Core\Entity\Setting;
use Zend\View\Model\{
    ViewModel, JsonModel
};

class SettingController extends CoreController
{
    /**
     * Show list of settings
     *
     * @return ViewModel
     */
    public function indexAction(): ViewModel
    {
        return new ViewModel();
    }
}
