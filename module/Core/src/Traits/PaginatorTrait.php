<?php

namespace Core\Traits;

use Zend\Paginator\Paginator as ZendPaginator;
use DoctrineModule\Paginator\Adapter\Collection as DoctrinePaginatorAdapterCollection;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;

trait PaginatorTrait {

	/**
     * @param Doctrine\Common\Collections\ArrayCollection $collection
     * @param int $currentPageNumber
     * @param int $perPageCount
     * @return ZendPaginator
     */
    public function getPaginator($collection, $currentPageNumber = 1, $perPageCount = 10)
    {
        return $this->getPaginatorByCollection($collection, $currentPageNumber, $perPageCount);
    }

    /**
     * @param Doctrine\Common\Collections\ArrayCollection $collection
     * @param int $currentPageNumber
     * @param int $perPageCount
     * @return ZendPaginator
     */
    public function getPaginatorByCollection($collection, $currentPageNumber = 1, $perPageCount = 10)
    {
        $adapter = new DoctrinePaginatorAdapterCollection($collection);
        return $this->getZendPaginator($adapter, $currentPageNumber, $perPageCount);
    }

    /**
     * @param Doctrine\ORM\Query $query
     * @param int $currentPageNumber
     * @param int $perPageCount
     * @return ZendPaginator
     */
    public function getPaginatorByQuery($query, $currentPageNumber = 1, $perPageCount = 10)
    {
        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        return $this->getZendPaginator($adapter, $currentPageNumber, $perPageCount);
    }

    /**
     * Returns the ZendPaginator
     *
     * @param Zend\Paginator\Adapter\AdapterInterface
     * @param int $currentPageNumber
     * @param int $perPageCount
     * @return Zend\Paginator\Paginator
     */
    protected function getZendPaginator($adapter, $currentPageNumber = 1, $perPageCount = 10)
    {
        $paginator = new ZendPaginator($adapter);
        $paginator->setDefaultItemCountPerPage($perPageCount);
        $paginator->setCurrentPageNumber($currentPageNumber);
        return $paginator;
    }
}