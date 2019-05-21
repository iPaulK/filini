<?php


namespace Core\Repository;


use Doctrine\ORM\Query;

class VideoReviewRepository extends AbstractRepository
{
    const TABLE_ALIAS = 'video_reviews';

    /**
     * Retrieve video reviews
     *
     * @return Query
     */
    public function findVideoReviews()
    {
        return $this->getQueryBuilder()->getQuery();
    }
}