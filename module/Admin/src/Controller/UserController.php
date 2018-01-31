<?php
namespace Admin\Controller;

use Core\Controller\CoreController;
use Core\Entity\User;
use Zend\View\Model\ViewModel;
use DoctrineModule\Validator\NoObjectExists;

class UserController extends CoreController
{
    /**
     * Show list of users
     *
     * @return ViewModel
     */
    public function indexAction(): ViewModel
    {
    	$page = $this->params()->fromQuery('page', 1);
        $limit = $this->params()->fromQuery('limit', 10);

        $query = $this->getRepository('User')->findUsers();

        $paginator = $this->getPaginatorByQuery($query, $page, $limit);
        return new ViewModel([
            'paginator' => $paginator
        ]);
    }

    public function editAction(): ViewModel
    {
        /** @var \Core\Entity\User $user */
        $user = $this->getEntity('User', $this->params()->fromRoute('id'));
        if (!$user) {
            $user = new User();
        }

        $form = $this->createUserForm($user);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getEm()->persist($user);
                $this->getEm()->flush();
                return $this->redirect()->toRoute('admin_user');
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }

    public function changePasswordAction(): ViewModel
    {
        // TODO
        return new ViewModel();
    }

    public function resetPasswordAction(): ViewModel
    {
        // TODO
        return new ViewModel();
    }

    /**
     * @param \Core\Entity\User $user
     * @return \Zend\Form\Form
     */
    protected function createUserForm($user)
    {
        $form = $this->createForm($user);
        $form->setAttributes([
            'action' => $this->url()->fromRoute('admin_user', ['action' => 'edit', 'id' => $user->getId()]),
        ]);
        $form->getInputFilter()->get('email')->getValidatorChain()->attach(new NoObjectExists([
            'object_repository' => $this->getRepository('User'),
            'fields' => ['email',],
            'messages' => [
                NoObjectExists::ERROR_OBJECT_FOUND => "Email already exists in database.",
            ]
        ]));
        return $form;
    }
}
