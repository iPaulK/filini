<?php

namespace Core\Service\Entity;

use Core\Entity\Category as CategoryEntity;

class Category extends AbstractEntityService
{
    /**
     * @return \Core\Entity\Category
     */
    public function getCategory()
    {
        return parent::getEntity();
    }

    /**
     * Check if status is enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->getCategory()->getStatus() == CategoryEntity::STATUS_ENABLED;
    }
}
