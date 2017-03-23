<?php
namespace BlackSheep\MusicLibraryBundle\Repository;

use Doctrine\ORM\Query;

/**
 * Interface AbstractRepositoryInterface
 */
interface AbstractRepositoryInterface
{
    /**
     * @return Query
     */
    public function queryAll();

    /**
     * @param $entity
     *
     * @return void
     */
    public function save($entity);
}
