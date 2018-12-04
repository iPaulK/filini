<?php

namespace Core\Service\Entity;

use Core\Entity\Product as ProductEntity;

class Product extends AbstractEntityService
{
    /**
     * @return \Core\Entity\Product
     */
    public function getProduct()
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
        return $this->getProduct()->getStatus() == ProductEntity::STATUS_ENABLED;
    }

    /**
     * Check whether product is sofa
     *
     * @return bool
     */
    public function isSofa()
    {
        return $this->getProduct() instanceof ProductEntity\Sofa;
    }

    /**
     * Check whether product is bed
     *
     * @return bool
     */
    public function isBed()
    {
        return $this->getProduct() instanceof ProductEntity\Bed;
    }
}
