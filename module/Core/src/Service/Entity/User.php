<?php
namespace Core\Service\Entity;

use Core\Entity\User as UserEntity;

class User extends AbstractEntityService
{
    /**
     * @return \Core\Entity\User
     */
    public function getUser()
    {
        return parent::getEntity();
    }

    /**
     * Retrieve Full Name
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->getUser()->getFirstName() . ' ' . $this->getUser()->getLastName();
    }
}
