<?php

namespace BlackSheep\MusicLibraryBundle\Repository;

use Doctrine\ORM\Query;

/**
 * Interface AbstractRepositoryInterface.
 */
interface AbstractRepositoryInterface
{
    /**
     * @return Query
     */
    public function queryAll();

    public function getList();

    /**
     * @param $entity
     */
    public function save($entity);
}
