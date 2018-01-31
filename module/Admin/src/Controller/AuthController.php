<?php
namespace Admin\Controller;

use Core\Controller\CoreController;
use Core\Entity\User;
use Zend\View\Model\ViewModel;

class UserController extends CoreController
{
    public function loginAction(): ViewModel
    {
        return new ViewModel();
    }

    public function logoutAction()
    {
        return new ViewModel();
    }
}
