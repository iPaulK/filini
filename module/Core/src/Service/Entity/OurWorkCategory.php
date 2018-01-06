<?php

namespace Core\Service\Entity;

use Core\Entity\OurWorkCategory as OurWorkCategoryEntity;

class OurWorkCategory extends AbstractEntityService
{
    /**
     * @return \Core\Entity\OurWorkCategory
     */
    public function getOurWorkCategory()
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
        return $this->getOurWorkCategory()->getStatus() == OurWorkCategoryEntity::STATUS_ENABLED;
    }
}
