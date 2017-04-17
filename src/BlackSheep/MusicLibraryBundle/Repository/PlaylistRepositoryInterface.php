<?php

namespace BlackSheep\MusicLibraryBundle\Repository;

use BlackSheep\MusicLibraryBundle\Model\PlaylistInterface;

/**
 * Interface AlbumsRepositoryInterface.
 */
interface PlaylistRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param $name
     *
     * @return PlaylistInterface
     */
    public function getByName($name);
}
