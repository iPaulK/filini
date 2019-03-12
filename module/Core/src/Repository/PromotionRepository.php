<?php

namespace Core\Repository;

class PromotionRepository extends AbstractRepository
{
    const TABLE_ALIAS = 'promotions';

    /**
     * Retrieve promotions
     *
     * @return \Doctrine\ORM\Query
     */
    public function findPromotions()
    {
        return $this->getQueryBuilder()->getQuery();
    }
}