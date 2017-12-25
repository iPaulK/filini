<?php

namespace Core\Repository;

use Doctrine\ORM\{
    EntityRepository,
    QueryBuilder
};

abstract class AbstractRepository extends EntityRepository
{
    /**
     * @var QueryBuilder
     */
    protected $queryBuilder;

    /**
     * @return QueryBuilder
     */
    protected function getQueryBuilder()
    {
        if (!$this->queryBuilder) {
            $this->queryBuilder = (new QueryBuilder($this->getEntityManager()))
                ->select(static::TABLE_ALIAS)
                ->from($this->getClassName(), static::TABLE_ALIAS);
        }

        return $this->queryBuilder;
    }

    /**
     * @param array $ids
     * @return \Doctrine\ORM\Query
     */
    public function getByIds(array $ids)
    {
        return $this->getQueryBuilder()
            ->andWhere(static::TABLE_ALIAS . '.id IN (:ids)')
            ->setParameter('ids', $ids)
            ->getQuery();
    }

    /**
     * @param string $field
     * @param string $direction
     * @return $this
     */
    protected function sort(string $field = 'id', string $direction = 'DESC')
    {
        $this->getQueryBuilder()->orderBy(static::TABLE_ALIAS . '.' . $field, $direction);

        return $this;
    }

    /**
     * @param string $field
     * @param mixed $value
     * @param string $condition
     * @return $this
     */
    protected function andWhere(string $field, $value, string $condition = '=')
    {
        $this->getQueryBuilder()
            ->andWhere(static::TABLE_ALIAS . '.' . $field . ' ' . $condition . ' :' . $field)
            ->setParameter($field, $value);

        return $this;
    }

    /**
     * @param int $limit
     * @return $this
     */
    protected function setLimit(int $limit)
    {
        $this->getQueryBuilder()->setMaxResults($limit);
        return $this;
    }
}
