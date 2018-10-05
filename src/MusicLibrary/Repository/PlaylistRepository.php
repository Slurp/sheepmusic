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
use BlackSheep\User\Entity\SheepUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

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

    public function getUserPlaylist(SheepUser $user)
    {
        $qb = $this->createQueryBuilder("p")
            ->where(':user MEMBER OF p.user')
            ->setParameter('user', $user);

        return $qb;
    }

    public function getUserPlaylistByName($name, SheepUser $user)
    {
        $qb = $this->getUserPlaylist($user)->andWhere('p.name = :name')->setParameter('name', $name);

        return $qb->setMaxResults(1)->getQuery()->getOneOrNullResult();
    }

    /**
     * @param string $name
     * @param SheepUser|null $user
     *
     * @return PlaylistInterface
     */
    public function getByName($name, SheepUser $user = null)
    {
        $playlist = null;
        if ($user !== null) {
            $playlist = $this->getUserPlaylistByName($name, $user);
        } else {
            $playlist = $this->findOneBy(['name' => $name]);
        }

        if ($playlist === null) {
            $playlist = PlaylistEntity::create($name);
        }

        return $playlist;
    }

    /**
     * @return QueryBuilder
     */
    protected function getListQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('a')->select(
            ['a.id', 'a.name', 'a.createdAt', 'a.updatedAt', 'a.cover']
        );
    }

    /**
     * @return array
     */
    public function getList()
    {
        return $this->getListQueryBuilder()->getQuery()->execute(
            [],
            Query::HYDRATE_ARRAY
        );
    }

    /**
     * @param SheepUser $user
     *
     * @return array
     */
    public function getListForUser(SheepUser $user)
    {
        return $this->getListQueryBuilder()->where(':user MEMBER OF a.user')
            ->setParameter('user', $user)
            ->getQuery()
            ->execute(
                [],
                Query::HYDRATE_ARRAY
            );
    }

    /**
     * @param $name
     * @param SongInterface[] $songs
     * @param SheepUser $user
     *
     * @return PlaylistInterface|bool
     */
    public function savePlaylistWithSongs($name, $songs, SheepUser $user = null)
    {
        $playlist = $this->getByName($name, $user);
        if ($songs !== null) {
            $position = 0;
            $playlist->setUser($user);
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
