<?php

namespace Core\Repository;

use \Core\Entity\ConversionType as ConversionTypeEntity;

class ConversionTypeRepository extends AbstractRepository
{
    const TABLE_ALIAS = 'conversion_types';

    /**
     * Retrieve conversion types
     *
     * @return \Doctrine\ORM\Query
     */
    public function findConversionTypes()
    {
        return $this->getQueryBuilder()->getQuery();
    }
}
