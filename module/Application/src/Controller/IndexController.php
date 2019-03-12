<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Mail;
use Core\Controller\CoreController;
use Zend\View\Model\ViewModel;

class IndexController extends CoreController
{
    public function indexAction()
    {
        return new ViewModel([
            'categories' => $this->getActiveCategories(),
            'promotions' => $this->getActivePromotions()
        ]);
    }

    public function sendProposalAction()
    {
        $mail = new Mail();
        $request = $this->getRequest();

        if ($request->isPost()) {
            $data = $this->params()->fromPost();
            $mail->sendProposal($data['phone'], $data['name']);
        }
    }
}
