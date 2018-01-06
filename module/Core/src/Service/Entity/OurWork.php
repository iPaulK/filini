<?php

namespace Core\Service\Entity;

use Core\Entity\OurWork as OurWorkEntity;

class OurWork extends AbstractEntityService
{
    /**
     * @return \Core\Entity\OurWork
     */
    public function getOurWork()
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
        return $this->getOurWork()->getStatus() == OurWorkEntity::STATUS_ENABLED;
    }
}
