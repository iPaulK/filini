<?php
namespace Admin\Controller;

use Core\Controller\CoreController;
use Core\Entity\Permission;
use Zend\View\Model\ViewModel;
use Doctrine\Common\Collections\ArrayCollection;

class PermissionController extends CoreController
{
    /**
     * Show list of permissions
     *
     * @return ViewModel
     */
    public function indexAction(): ViewModel
    {
        $page = $this->params()->fromQuery('page', 1);
        $limit = $this->params()->fromQuery('limit', 10);

        $query = $this->getRepository(Permission::class)->findPermissions();

        $paginator = $this->getPaginatorByQuery($query, $page, $limit);
        return new ViewModel([
            'paginator' => $paginator
        ]);
    }

    /**
     * Edit permission action
     *
     * @return ViewModel
     */
    public function editAction(): ViewModel
    {
        /** @var \Core\Entity\Permission $permission */
        $permission = $this->getEntity(Permission::class, $this->params()->fromRoute('id'));
        if (!$permission) {
            $permission = new Permission();
        }

        $form = $this->createPermissionForm($permission);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getEm()->persist($permission);
                $this->getEm()->flush();
                return $this->redirect()->toRoute('admin_user_permission');
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }

    /**
     * Remove permission action
     *
     * @return ViewModel
     */
    public function removeAction(): ViewModel
    {
        $permission = $this->getEntity(Permission::class, $this->params()->fromRoute('id'));
        if ($permission) {
            $this->getEm()->remove($permission);
            $this->getEm()->flush();
        }
        return $this->redirect()->toRoute('admin_user_permission');
    }

    /**
     * @param \Core\Entity\Permission $permission
     * @return \Zend\Form\Form
     */
    protected function createPermissionForm($permission)
    {
        $form = $this->createForm($permission);
        $form->setAttributes([
            'action' => $this->url()->fromRoute('admin_user_permission', ['action' => 'edit', 'id' => $permission->getId()]),
        ]);
        return $form;
    }
}
