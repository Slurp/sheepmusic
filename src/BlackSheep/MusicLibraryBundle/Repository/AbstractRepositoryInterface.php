<?php

namespace BlackSheep\MusicLibraryBundle\Repository;

/**
 * Interface AbstractRepositoryInterface.
 */
interface AbstractRepositoryInterface
{
    /**
     * @param $entity
     */
    public function save($entity);
}
