<?php
namespace Core\Repository;

/**
 * PermissionRepository
 */
class PermissionRepository extends AbstractRepository
{
    const TABLE_ALIAS = 'permissions';

    /**
     * Retrieve permissions
     *
     * @return \Doctrine\ORM\Query
     */
    public function findPermissions()
    {
        return $this->getQueryBuilder()->getQuery();
    }
}
