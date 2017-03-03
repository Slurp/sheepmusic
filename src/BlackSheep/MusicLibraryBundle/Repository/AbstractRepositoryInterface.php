<?php
namespace BlackSheep\MusicLibraryBundle\Repository;

/**
 * Interface AbstractRepositoryInterface
 */
interface AbstractRepositoryInterface
{
    /**
     * @param $entity
     *
     * @return void
     */
    public function save($entity);
}
