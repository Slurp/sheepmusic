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

use BlackSheep\MusicLibrary\Entity\AlbumEntity;
use BlackSheep\MusicLibrary\Entity\ArtistsEntity;
use BlackSheep\MusicLibrary\Model\AlbumInterface;
use BlackSheep\MusicLibrary\Model\ArtistInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query;

/**
 * SongsRepository.
 */
class AlbumsRepository extends AbstractRepository implements AlbumsRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    protected static function getEntityClass(): string
    {
        return AlbumEntity::class;
    }

    /**
     * @var array
     */
    protected $listSelection = ['a.id', 'a.slug', 'a.name', 'a.createdAt', 'a.playCount', 'a.lossless'];

    /**
     * {@inheritdoc}
     */
    public function queryAll()
    {
        return $this->createQueryBuilder('a')->addOrderBy('a.name', 'ASC')->getQuery()->setFetchMode(
            AlbumEntity::class,
            'artist',
            ClassMetadata::FETCH_EAGER
        );
    }

    /**
     * @param ArtistsEntity $artists
     * @param               $albumName
     * @param               $extraInfo
     *
     * @return AlbumInterface|null
     */
    public function addOrUpdateByArtistAndName(ArtistInterface $artists, $albumName, $extraInfo)
    {
        /** @var AlbumInterface $album */
        $album = null;
        if (isset($extraInfo['album_mbid']) && empty($extraInfo['album_mbid']) === false) {
            $album = $this->getArtistAlbumByMBID($extraInfo['album_mbid']);
        }
        if ($album === null) {
            $album = $this->getArtistAlbumByName($artists, $albumName);
        }

        if ($album === null) {
            $album = AlbumEntity::createArtistAlbum($albumName, $artists, $extraInfo);
        }

        return $album;
    }

    /**
     * @param AlbumInterface $album
     */
    public function checkSongsForAlbum(AlbumInterface $album)
    {
        // remove songs that are not there
        foreach ($album->getSongs() as $song) {
            if (file_exists($song->getPath()) === false) {
                $album->removeSong($song);
                $this->getEntityManager()->remove($song);
            }
        }
    }

    /**
     * @param ArtistInterface $artist
     * @param $albumName
     *
     * @return null|object
     */
    public function getArtistAlbumByName(ArtistInterface $artist, $albumName)
    {
        return $this->findOneBy(
            ['artist' => $artist, 'name' => $albumName]
        );
    }

    /**
     * @param $mbId
     *
     * @return null|object
     */
    public function getArtistAlbumByMBID($mbId)
    {
        return $this->findOneBy(
            ['musicBrainzId' => $mbId]
        );
    }

    /**
     * @return \Doctrine\ORM\Query
     */
    public function getRecentAlbums()
    {
        return $this->createQueryBuilder('a')
            ->addOrderBy('a.createdAt', 'DESC')
            ->getQuery()->setFetchMode(AlbumEntity::class, 'artist', ClassMetadata::FETCH_EAGER);
    }

    /**
     * @return Query
     */
    public function getMostPlayedAlbums()
    {
        return $this->createQueryBuilder('a')
            ->where('a.playCount > 0')
            ->andWhere('a.playCount is not NULL')
            ->addOrderBy('a.playCount', 'DESC')
            ->getQuery()->setFetchMode(AlbumEntity::class, 'artist', ClassMetadata::FETCH_EAGER);
    }

    /**
     * @return array
     */
    public function getRecentAlbumsList()
    {
        return $this->createQueryBuilder('a')->select(
            ['a.id', 'a.slug', 'a.name', 'a.createdAt', 'a.playCount', 'a.lossless']
        )->addOrderBy('a.createdAt', 'DESC')->getQuery()->execute(
            [],
            Query::HYDRATE_ARRAY
        );
    }

    /**
     * @return AlbumEntity[]
     */
    public function getLatestAlbums()
    {
        return $this->createQueryBuilder('a')
            ->select()
            ->addOrderBy('a.createdAt', 'DESC')
            ->setMaxResults(9)
            ->getQuery()
            ->getResult();
    }
}
