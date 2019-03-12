<?php

namespace Admin\Controller;

use Core\Controller\CoreController;
use Core\Entity\MoneyRate;
use Zend\View\Model\ViewModel;

class MoneyRateController extends CoreController
{
    public function indexAction()
    {
        $page = $this->params()->fromQuery('page', 1);
        $limit = $this->params()->fromQuery('limit', 10);

        $query = $this->getRepository(MoneyRate::class)->findMoneyRates();

        $paginator = $this->getPaginatorByQuery($query, $page, $limit);

        return new ViewModel([
            'paginator' => $paginator
        ]);
    }

    public function editAction()
    {
        /** @var \Core\Entity\MoneyRate $moneyRate */
        $moneyRate = $this->getEntity(MoneyRate::class, $this->params()->fromRoute('id'));

        if (!$moneyRate) {
            $moneyRate = new MoneyRate();
        }

        $form = $this->createMoneyRateForm($moneyRate);
        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getEm()->persist($moneyRate);
                $this->getEm()->flush();
                return $this->redirect()->toRoute('admin_money_rate');
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }

    /**
     * Remove money rate action
     *
     * @return \Zend\Http\Response
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function removeAction()
    {
        $moneyRate = $this->getEntity(MoneyRate::class, $this->params()->fromRoute('id'));

        if ($moneyRate) {
            $this->getEm()->remove($moneyRate);
            $this->getEm()->flush();
        }

        return $this->redirect()->toRoute('admin_money_rate');
    }

    /**
     * @param \Core\Entity\MoneyRate $moneyRate
     * @return \Zend\Form\Form
     */
    protected function createMoneyRateForm($moneyRate)
    {
        $form = $this->createForm($moneyRate);
        $form->setAttributes([
            'action' => $this->url()->fromRoute('admin_money_rate', ['action' => 'edit', 'id' => $moneyRate->getId()]),
        ]);

        return $form;
    }
}