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

    /**
     * Check if status is active
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->getUser()->getStatus() === UserEntity::STATUS_ACTIVE;
    }

    /**
     * Retrieve available statuses as array.
     *
     * @return array
     */
    public static function getStatusList() 
    {
        return [
            UserEntity::STATUS_ACTIVE => 'Active',
            UserEntity::STATUS_RETIRED => 'Retired'
        ];
    }    
    
    /**
     * Retrieve status as string.
     *
     * @return string
     */
    public function getStatusAsString()
    {
        $list = self::getStatusList();
        if (isset($list[$this->getUser()->getStatus()])) {
            return $list[$this->getUser()->getStatus()];
        }
        
        return 'Unknown';
    }
}
