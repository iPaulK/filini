<?php
namespace Core\Repository;

/**
 * RoleRepository
 */
class RoleRepository extends AbstractRepository
{
    const TABLE_ALIAS = 'roles';

    /**
     * Retrieve roles
     *
     * @return \Doctrine\ORM\Query
     */
    public function findRoles()
    {
        return $this->getQueryBuilder()->getQuery();
    }
}
