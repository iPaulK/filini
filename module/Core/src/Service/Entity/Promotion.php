<?php

namespace Core\Service\Entity;

use Core\Entity\Promotion as PromotionEntity;


class Promotion extends AbstractEntityService
{
    /**
     * @return \Core\Entity\Promotion
     */
    public function getPromotion()
    {
        return parent::getEntity();
    }

    /**
     * Check if status is enabled
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->getPromotion()->getStatus() == PromotionEntity::STATUS_ACTIVE;
    }
}