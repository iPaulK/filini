<?php

namespace Core\Repository;

use \Core\Entity\OurWorkCategory;

class OurWorkCategoryRepository extends AbstractRepository
{
    const TABLE_ALIAS = 'our_work_categories';

    /**
     * Find our work category by slug
     *
     * @param string $slug
     * @return OurWork | null
     */
    public function findOneBySlug($slug)
    {
        return $this->findOneBy(array(
            'slug' => $slug,
        ));
    }

    /**
     * Retrieve our work categories
     *
     * @return \Doctrine\ORM\Query
     */
    public function findCategories()
    {
        return $this->getQueryBuilder()->getQuery();
    }

    /**
     * Find categories by status
     *
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

    public function getActive()
    {
        return $this->findByStatus(OurWorkCategory::STATUS_ENABLED);
    }
}
