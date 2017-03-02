<?php

namespace BlackSheep\MusicLibraryBundle\Repository;

use BlackSheep\MusicLibraryBundle\Entity\SongEntity;

/**
 * Interface SongsRepositoryInterface.
 */
interface SongsRepositoryInterface
{
    /**
     * @param $songInfo
     *
     * @return null|SongEntity
     */
    public function needsImporting($songInfo);
}
