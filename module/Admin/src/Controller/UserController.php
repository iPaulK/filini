<?php
namespace Admin\Controller;

use Core\Controller\CoreController;
use Core\Entity\User;
use Zend\View\Model\ViewModel;
use DoctrineModule\Validator\NoObjectExists;
use Zend\Crypt\Password\Bcrypt;
use Zend\Validator\Callback;

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

        $query = $this->getRepository(User::class)->findUsers();

        $paginator = $this->getPaginatorByQuery($query, $page, $limit);
        return new ViewModel([
            'paginator' => $paginator
        ]);
    }

    /**
     * @return ViewModel
     */
    public function addAction(): ViewModel
    {
        /** @var \Core\Entity\User $user */
        $user = $this->getEntity(User::class, $this->params()->fromRoute('id'));
        if (!$user) {
            $user = new User();
        }

        $form = $this->createAddUserForm($user);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $bcrypt = new Bcrypt();
                $bcrypt->setCost(USER::BCRYPT_PASSWORD_COST);
                $user->setPassword($bcrypt->create($form->get('password')->getValue()));
                
                $this->getEm()->persist($user);
                $this->getEm()->flush();
                return $this->redirect()->toRoute('admin_user');
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }

    /**
     * @return ViewModel
     */
    public function editAction(): ViewModel
    {
        /** @var \Core\Entity\User $user */
        $user = $this->getEntity(User::class, $this->params()->fromRoute('id'));
        if (!$user) {
            $user = new User();
        }

        $form = $this->createEditUserForm($user);

        $request = $this->getRequest();
        if ($request->isPost()) {
            // Do not allow to change user email if another user with such email already exits.
            if($user->getEmail() != $request->getPost('email')) {
                $form = $this->attachEmailExistsValidator($form);
            }
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

    /**
     * @return ViewModel
     */
    public function changePasswordAction(): ViewModel
    {
        /** @var \Core\Entity\User $user */
        $user = $this->getEntity(User::class, $this->params()->fromRoute('id'));
        if (!$user) {
            return $this->redirect()->toRoute('admin_user');
        }

        $form = $this->createChangePasswordForm($user);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $bcrypt = new Bcrypt();
                $bcrypt->setCost(USER::BCRYPT_PASSWORD_COST);
                $user->setPassword($bcrypt->create($form->get('password')->getValue()));
                $this->getEm()->persist($user);
                $this->getEm()->flush();
                return $this->redirect()->toRoute('admin_user');
            }
        }

        return new ViewModel([
            'form' => $form,
        ]);
    }

    /**
     * @param \Core\Entity\User $user
     * @return \Zend\Form\Form
     */
    protected function createEditUserForm($user)
    {
        $form = $this->createForm($user);
        $form->setAttributes([
            'action' => $this->url()->fromRoute('admin_user', ['action' => 'edit', 'id' => $user->getId()]),
        ]);
        $form->setValidationGroup('email', 'status', 'firstName', 'lastName');
        return $form;
    }

    /**
     * @param \Core\Entity\User $user
     * @return \Zend\Form\Form
     */
    protected function createAddUserForm($user)
    {
        $form = $this->createForm($user);
        $form->setAttributes([
            'action' => $this->url()->fromRoute('admin_user', ['action' => 'add', 'id' => $user->getId()]),
        ]);
        $form = $this->attachEmailExistsValidator($form);
        
        return $form;
    }

    /**
     * @param \Core\Entity\User $user
     * @return \Zend\Form\Form
     */
    protected function createChangePasswordForm($user)
    {
        $form = $this->createForm($user);
        
        $oldPassword = clone $form->get('password');
        
        $form->add($oldPassword->setName('oldPassword'));
        
        $oldPasswordValidationCallback = new Callback(function ($value) use ($user) {
            $bcrypt = new Bcrypt;
            $bcrypt->setCost(USER::BCRYPT_PASSWORD_COST);
            return $bcrypt->verify($value, $user->getPassword());
        });
        
        $oldPasswordValidationCallback->setMessage('Incorrect old password.');
        
        $form->getInputFilter()->get('oldPassword')
            ->setRequired(true)
            ->getValidatorChain()->attach($oldPasswordValidationCallback);

        $form->setValidationGroup('oldPassword', 'password', 'confirmPassword');

        return $form;
    }

    /**
     * @var \Zend\Form\Form
     * @return \Zend\Form\Form
     */
    protected function attachEmailExistsValidator($form)
    {
        $form->getInputFilter()->get('email')->getValidatorChain()->attach(new NoObjectExists([
            'object_repository' => $this->getRepository(User::class),
            'fields' => ['email'],
            'messages' => [
                NoObjectExists::ERROR_OBJECT_FOUND => "Email already exists in database.",
            ]
        ]));

        return $form;
    }
}
