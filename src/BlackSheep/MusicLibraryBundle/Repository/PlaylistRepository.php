<?php

namespace BlackSheep\MusicLibraryBundle\Repository;

use BlackSheep\MusicLibraryBundle\Entity\PlaylistEntity;
use BlackSheep\MusicLibraryBundle\Model\Playlist;
use BlackSheep\MusicLibraryBundle\Model\PlaylistInterface;

/**
 * SongsRepository
 */
class PlaylistRepository extends AbstractRepository implements PlaylistRepositoryInterface
{
    /**
     * @param $name
     *
     * @return PlaylistInterface
     */
    public function getByName($name)
    {
        $playlist = $this->findOneBy(['name' => $name]);
        if ($playlist === null) {
            $playlist = PlaylistEntity::create($name);
        }

        return $playlist;
    }
}
