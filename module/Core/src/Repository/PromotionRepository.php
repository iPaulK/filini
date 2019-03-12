<?php

namespace Core\Repository;

use Core\Entity\Promotion;

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

    /**
     * Find promotions by status
     *
     * @param $status
     * @return \Doctrine\ORM\Query
     */
    public function findByStatus($status)
    {
        $queryBuilder = $this->getQueryBuilder();
        if ($status) {
            $queryBuilder = $this->whereByStatus($queryBuilder, $status);
        }
        return $queryBuilder->getQuery();
    }

    public function getActive()
    {
        return $this->findByStatus(Promotion::STATUS_ACTIVE);
    }

    /**
     * Add filter by status to QueryBuilder.
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder
     * @param string $status
     * @param string $condition
     * @return \Doctrine\ORM\QueryBuilder
     */
    private function whereByStatus($queryBuilder, $status, $condition = 'and')
    {
        if ($condition == 'or') {
            $queryBuilder->orWhere(self::TABLE_ALIAS . '.status LIKE :status');
        } else {
            $queryBuilder->andWhere(self::TABLE_ALIAS . '.status LIKE :status');
        }
        $queryBuilder->setParameter('status', '%' . $status . '%');

        return $queryBuilder;
    }
}