<?php

namespace BlackSheep\MusicLibraryBundle\Repository;

use BlackSheep\MusicLibraryBundle\Entity\PlaylistEntity;
use BlackSheep\MusicLibraryBundle\Helper\PlaylistCoverHelper;
use BlackSheep\MusicLibraryBundle\Model\PlaylistInterface;
use BlackSheep\MusicLibraryBundle\Model\SongInterface;
use Doctrine\ORM\OptimisticLockException;
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
    public function getList()
    {
        return $this->createQueryBuilder('a')->select(
            ['a.id', 'a.name', 'a.createdAt', 'a.updatedAt', 'a.cover']
        )->getQuery()->execute(
            [],
            Query::HYDRATE_ARRAY
        );
    }

    /**
     * @param $name
     * @param SongInterface[] $songs
     *
     * @return PlaylistInterface|bool
     */
    public function savePlaylistWithSongs($name, $songs)
    {
        $playlist = $this->getByName($name);
        if ($songs !== null) {
            foreach ($songs as $song) {
                $playlist->addSong($song);
            }
            $cover = new PlaylistCoverHelper();
            $playlist->setCover($cover->createCoverForPlaylist($playlist, false));
            try {
                $this->save($playlist);
            } catch (OptimisticLockException $e) {
                return false;
            }
            return $playlist;
        }
        return false;
    }
}
