<?php

namespace Core\DataFixtures\ORM;

use Core\Entity\MoneyRate;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadDollarDefaultRate extends AbstractFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $dollarRate = new MoneyRate();
        $dollarRate
            ->setName('Dollar')
            ->setRateValue(2.14);

        $manager->persist($dollarRate);
        $manager->flush();
    }
}