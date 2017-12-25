<?php

namespace Core\Repository;

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
}
