<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Repository;

use BlackSheep\MusicLibrary\Entity\PlaylistEntity;
use BlackSheep\MusicLibrary\Entity\PlaylistsSongsEntity;
use BlackSheep\MusicLibrary\Helper\PlaylistCoverHelper;
use BlackSheep\MusicLibrary\Model\PlaylistInterface;
use BlackSheep\MusicLibrary\Model\SongInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\Query;

/**
 * SongsRepository.
 */
class PlaylistRepository extends AbstractRepository implements PlaylistRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    protected static function getEntityClass(): string
    {
        return PlaylistEntity::class;
    }

    /**
     * @param string$name
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
     * @return PlaylistEntity|bool
     */
    public function savePlaylistWithSongs($name, $songs)
    {
        $playlist = $this->getByName($name);
        if ($songs !== null) {
            $position = 0;
            $playlist->setSongs(new ArrayCollection());
            foreach ($songs as $song) {
                $plSong = new PlaylistsSongsEntity();
                $plSong->setSong($song);
                $plSong->setPosition($position++);
                $playlist->addSong($plSong);
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
