<?php

namespace Core\Repository;

use \Core\Entity\Category as CategoryEntity;

class CategoryRepository extends AbstractRepository
{
    const TABLE_ALIAS = 'categories';

    /**
     * Find category by slug
     *
     * @param string $slug
     * @return Category | null
     */
    public function findOneBySlug($slug)
    {
        return $this->findOneBy(array(
            'slug' => $slug,
        ));
    }

    /**
     * Retrieve categories
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
}
