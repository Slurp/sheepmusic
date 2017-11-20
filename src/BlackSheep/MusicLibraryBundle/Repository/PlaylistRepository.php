<?php

namespace BlackSheep\MusicLibraryBundle\Repository;

use BlackSheep\MusicLibraryBundle\Entity\PlaylistEntity;
use BlackSheep\MusicLibraryBundle\Model\Playlist;
use BlackSheep\MusicLibraryBundle\Model\PlaylistInterface;
use Doctrine\ORM\Query;

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

    /**
     * @return array
     */
    public function getLists()
    {
        return $this->createQueryBuilder('a')->select(
            ['a.id', 'a.name', 'a.createdAt', 'a.updatedAt','a.cover']
        )->getQuery()->execute(
            [],
            Query::HYDRATE_ARRAY
        );
    }
}
