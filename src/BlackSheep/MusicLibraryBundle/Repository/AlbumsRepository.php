<?php

namespace BlackSheep\MusicLibraryBundle\Repository;

use BlackSheep\MusicLibraryBundle\Entity\AlbumEntity;
use BlackSheep\MusicLibraryBundle\Entity\ArtistsEntity;
use BlackSheep\MusicLibraryBundle\Model\AlbumInterface;
use Doctrine\ORM\Mapping\ClassMetadata;

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
        return $this->createQueryBuilder('a')->getQuery()->setFetchMode(
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
}
