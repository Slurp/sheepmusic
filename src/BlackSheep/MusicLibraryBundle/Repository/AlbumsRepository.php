<?php

namespace BlackSheep\MusicLibraryBundle\Repository;

use BlackSheep\MusicLibraryBundle\Entity\AlbumEntity;
use BlackSheep\MusicLibraryBundle\Entity\ArtistsEntity;
use BlackSheep\MusicLibraryBundle\Model\AlbumInterface;

/**
 * SongsRepository
 */
class AlbumsRepository extends AbstractRepository implements AlbumsRepositoryInterface
{
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
        if ($album == null) {
            $album = AlbumEntity::createArtistAlbum($albumName, $artists, $extraInfo);
            $this->save($album);
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
     * @param int $offset
     * @param int $limit
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getRecentAlbums($offset = 0, $limit = 50)
    {
        $queryBuilder = $this->createQueryBuilder('a')
            ->addOrderBy('a.createdAt', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return $queryBuilder->getQuery()->getResult();
    }
}
