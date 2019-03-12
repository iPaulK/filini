<?php

namespace Admin\Controller;

use Core\Controller\CoreController;
use Core\Entity\News;
use Core\Entity\Promotion;
use Zend\View\Model\{
    ViewModel, JsonModel
};

class PromotionController extends CoreController
{
    /**
     * Show list of promotions
     *
     * @return ViewModel
     */
    public function indexAction(): ViewModel
    {
        $page = $this->params()->fromQuery('page', 1);
        $limit = $this->params()->fromQuery('limit', 10);

        $query = $this->getRepository(Promotion::class)->findPromotions();

        $paginator = $this->getPaginatorByQuery($query, $page, $limit);

        return new ViewModel([
            'paginator' => $paginator
        ]);
    }

    public function editAction()
    {
        /** @var \Core\Entity\Promotion $promotion */
        $promotion = $this->getEntity(Promotion::class, $this->params()->fromRoute('id'));

        if (!$promotion) {
            $promotion = new Promotion();
        }

        $form = $this->createPromotionForm($promotion);
        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getEm()->persist($promotion);
                $this->getEm()->flush();

                return $this->redirect()->toRoute('admin_promotions');
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }

    /**
     * Remove promotion action
     *
     * @return \Zend\Http\Response
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function removeAction()
    {
        $promotion = $this->getEntity(Promotion::class, $this->params()->fromRoute('id'));

        if ($promotion) {
            $this->getEm()->remove($promotion);
            $this->getEm()->flush();
        }

        return $this->redirect()->toRoute('admin_promotions');
    }

    /**
     * @param \Core\Entity\Promotion $promotion
     * @return \Zend\Form\Form
     */
    protected function createPromotionForm($promotion)
    {
        $form = $this->createForm($promotion);
        $form->setAttributes([
            'action' => $this->url()->fromRoute('admin_promotions', ['action' => 'edit', 'id' => $promotion->getId()]),
        ]);

        return $form;
    }
}
