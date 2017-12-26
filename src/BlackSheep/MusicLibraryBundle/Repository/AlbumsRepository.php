<?php

namespace BlackSheep\MusicLibraryBundle\Repository;

use BlackSheep\MusicLibraryBundle\Entity\AlbumEntity;
use BlackSheep\MusicLibraryBundle\Entity\ArtistsEntity;
use BlackSheep\MusicLibraryBundle\Model\AlbumInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query;

/**
 * SongsRepository
 */
class AlbumsRepository extends AbstractRepository implements AlbumsRepositoryInterface
{
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
    public function addOrUpdateByArtistAndName(ArtistsEntity $artists, $albumName, $extraInfo)
    {
        $album = $this->getArtistAlbumByName($artists, $albumName);
        if ($album === null) {
            $album = AlbumEntity::createArtistAlbum($albumName, $artists, $extraInfo);
        }

        return $album;
    }

    /**
     * @param ArtistsEntity $artist
     * @param $albumName
     *
     * @return null|object
     */
    public function getArtistAlbumByName(ArtistsEntity $artist, $albumName)
    {
        return $this->findOneBy(
            ['artist' => $artist, 'name' => $albumName]
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
            ['a.id', 'a.slug', 'a.name', 'a.createdAt', 'a.updatedAt', 'a.playCount']
        )->addOrderBy('a.createdAt', 'DESC')->getQuery()->execute(
            [],
            Query::HYDRATE_ARRAY
        );
    }
}
