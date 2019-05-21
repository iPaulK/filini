<?php


namespace Core\Repository;


class VideoReviewRepository extends AbstractRepository
{
    const TABLE_ALIAS = 'conversion_types';

    /**
     * Retrieve video reviews
     *
     * @return \Doctrine\ORM\Query
     */
    public function findVideoReviews()
    {
        return $this->getQueryBuilder()->getQuery();
    }
}