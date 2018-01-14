<?php

namespace BlackSheep\MusicLibraryBundle\Repository;

use BlackSheep\MusicLibraryBundle\Model\AlbumInterface;
use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;

/**
 * Interface AlbumsRepositoryInterface.
 */
interface AlbumsRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param ArtistInterface $artists
     * @param                 $albumName
     * @param                 $extraInfo
     *
     * @return AlbumInterface|null
     */
    public function addOrUpdateByArtistAndName(ArtistInterface $artists, $albumName, $extraInfo);

    /**
     * @param ArtistInterface $artist
     * @param                 $albumName
     *
     * @return null|AlbumInterface
     */
    public function getArtistAlbumByName(ArtistInterface $artist, $albumName);

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getRecentAlbums();
}
