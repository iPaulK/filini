<?php

namespace Core\Repository;

class MoneyRateRepository extends AbstractRepository
{
    const TABLE_ALIAS = 'money_rates';

    /**
     * Retrieve money rates
     *
     * @return \Doctrine\ORM\Query
     */
    public function findMoneyRates()
    {
        return $this->getQueryBuilder()->getQuery();
    }
}