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
use BlackSheep\User\Model\UserInterface;
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

    public function getUserPlaylist(UserInterface $user)
    {
        $qb = $this->createQueryBuilder('p')
            ->where(':user MEMBER OF p.user')
            ->setParameter('user', $user);

        return $qb;
    }

    public function getUserPlaylistByName($name, UserInterface $user)
    {
        $qb = $this->getUserPlaylist($user)->andWhere('p.name = :name')->setParameter('name', $name);

        return $qb->setMaxResults(1)->getQuery()->getOneOrNullResult();
    }

    /**
     * @param string $name
     * @param UserInterface|null $user
     *
     * @return PlaylistInterface
     */
    public function getByName($name, UserInterface $user = null)
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
     * @param UserInterface $user
     *
     * @return array
     */
    public function getListForUser(UserInterface $user)
    {
        return $this->getListQueryBuilder()
            ->where(':user MEMBER OF a.user')
            ->orWhere('a.type = :type')
            ->setParameter('user', $user)
            ->setParameter('type', PlaylistInterface::SYSTEM_TYPE)
            ->getQuery()
            ->execute(
                [],
                Query::HYDRATE_ARRAY
            );
    }

    /**
     * @param $name
     * @param SongInterface[] $songs
     * @param UserInterface $user
     *
     * @return PlaylistInterface|bool
     */
    public function savePlaylistWithSongs($name, $songs, UserInterface $user = null)
    {
        $playlist = $this->getByName($name, $user);
        if ($songs !== null && count($songs) >= 1) {
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
