<?php
namespace Admin\Controller;

use Core\Controller\CoreController;
use Core\Entity\Role;
use Zend\View\Model\ViewModel;
use Doctrine\Common\Collections\ArrayCollection;

class RoleController extends CoreController
{
    /**
     * Show list of roles
     *
     * @return ViewModel
     */
    public function indexAction(): ViewModel
    {
        $page = $this->params()->fromQuery('page', 1);
        $limit = $this->params()->fromQuery('limit', 10);

        $query = $this->getRepository('Role')->findRoles();

        $paginator = $this->getPaginatorByQuery($query, $page, $limit);
        return new ViewModel([
            'paginator' => $paginator
        ]);
    }

    /**
     * Edit role action
     *
     * @return ViewModel
     */
    public function editAction(): ViewModel
    {
        /** @var \Core\Entity\Role $role */
        $role = $this->getEntity('Role', $this->params()->fromRoute('id'));
        if (!$role) {
            $role = new Role();
        }

        $form = $this->createRoleForm($role);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getEm()->persist($role);
                $this->getEm()->flush();
                return $this->redirect()->toRoute('admin_user_role');
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }

    /**
     * Remove role action
     *
     * @return ViewModel
     */
    public function removeAction(): ViewModel
    {
        $role = $this->getEntity('Role', $this->params()->fromRoute('id'));
        if ($role) {
            $this->getEm()->remove($role);
            $this->getEm()->flush();
        }
        return $this->redirect()->toRoute('admin_user_role');
    }

    /**
     * @param \Core\Entity\Role $role
     * @return \Zend\Form\Form
     */
    protected function createRoleForm($role)
    {
        $form = $this->createForm($role);
        $form->setAttributes([
            'action' => $this->url()->fromRoute('admin_user_role', ['action' => 'edit', 'id' => $role->getId()]),
        ]);
        return $form;
    }
}
