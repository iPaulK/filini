<?php

namespace Admin\Controller;

use Core\Controller\CoreController;
use Core\Entity\OurWorkCategory;
use Zend\View\Model\{
    ViewModel, JsonModel
};
use Doctrine\Common\Collections\ArrayCollection;

class OurWorkCategoryController extends CoreController
{
    /**
     * Show list of categories
     *
     * @return ViewModel
     */
    public function indexAction(): ViewModel
    {
        $page = $this->params()->fromQuery('page', 1);
        $limit = $this->params()->fromQuery('limit', 10);

        $query = $this->getRepository('OurWorkCategory')->findCategories();

        $paginator = $this->getPaginatorByQuery($query, $page, $limit);
        return new ViewModel([
            'paginator' => $paginator
        ]);
    }

    /**
     * Edit category action
     *
     * @return ViewModel
     */
    public function editAction(): ViewModel
    {
        /** @var \Core\Entity\OurWorkCategory $category */
        $category = $this->getEntity('OurWorkCategory', $this->params()->fromRoute('id'));
        if (!$category) {
            $category = new OurWorkCategory();
        }

        $form = $this->createCategoryForm($category);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getEm()->persist($category);
                $this->getEm()->flush();
                return $this->redirect()->toRoute('admin_work_category');
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }

    /**
     * Remove category action
     *
     * @return ViewModel
     */
    public function removeAction(): ViewModel
    {
        $category = $this->getEntity('OurWorkCategory', $this->params()->fromRoute('id'));
        if ($category) {
            $this->getEm()->remove($category);
            $this->getEm()->flush();
        }
        return $this->redirect()->toRoute('admin_work_category');
    }

    /**
     * @param \Core\Entity\OurWorkCategory $category
     * @return \Zend\Form\Form
     */
    protected function createCategoryForm($category)
    {
        $form = $this->createForm($category);
        $form->setAttributes([
            'action' => $this->url()->fromRoute('admin_work_category', ['action' => 'edit', 'id' => $category->getId()]),
        ]);
        return $form;
    }
}
