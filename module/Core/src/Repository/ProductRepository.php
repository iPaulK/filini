<?php

namespace Core\Repository;

use Doctrine\ORM\QueryBuilder;

class ProductRepository extends AbstractRepository
{
    const TABLE_ALIAS = 'products';

    /**
     * Find product by slug
     *
     * @param string $slug
     * @return Product | null
     */
    public function findOneBySlug($slug)
    {
        return $this->findOneBy(array(
            'slug' => $slug,
        ));
    }

    /**
     * Retrieve products
     *
     * @return \Doctrine\ORM\Query
     */
    public function findProducts()
    {
        $this
            ->sort('id', 'DESC');
        return $this->getQueryBuilder()->getQuery();
    }

    /**
     * @param string $discr
     * @return integer
     */
    public function getCountByDiscr($discr = '\Core\Entity\Product')
    {
        $queryBuilder = new QueryBuilder($this->getEntityManager());
        $queryBuilder->select('COUNT(' . self::TABLE_ALIAS . '.id)')
            ->from($discr, self::TABLE_ALIAS);
        $result = $queryBuilder->getQuery()->getSingleScalarResult();
        return $result;
    }
}
