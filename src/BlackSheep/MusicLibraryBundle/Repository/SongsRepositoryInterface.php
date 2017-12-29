<?php

namespace BlackSheep\MusicLibraryBundle\Repository;

use BlackSheep\MusicLibraryBundle\Entity\SongEntity;

/**
 * Interface SongsRepositoryInterface.
 */
interface SongsRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param $songInfo
     *
     * @return null|SongEntity
     */
    public function needsImporting($songInfo);

    /**
     * @return null|object
     */
    public function lastImportDate();
}
