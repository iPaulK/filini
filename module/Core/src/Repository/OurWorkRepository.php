<?php

namespace Core\Repository;

use Doctrine\ORM\QueryBuilder;

class OurWorkRepository extends AbstractRepository
{
    const TABLE_ALIAS = 'our_works';

    /**
     * Find work by slug
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
     * Retrieve our works
     *
     * @return \Doctrine\ORM\Query
     */
    public function findOurWorks()
    {
        return $this->getQueryBuilder()->getQuery();
    }
}
