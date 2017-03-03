<?php

namespace BlackSheep\MusicLibraryBundle\Repository;

use BlackSheep\MusicLibraryBundle\Entity\ArtistsEntity;
use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;

/**
 * Interface ArtistRepositoryInterface.
 */
interface ArtistRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param      $artistName
     * @param null $musicBrainzId
     *
     * @return ArtistsEntity|null
     */
    public function addOrUpdate($artistName, $musicBrainzId = null);

    /**
     * @param $artistName
     *
     * @return ArtistInterface|null
     */
    public function getArtistByName($artistName);

    /**
     * @param $musicBrainzId
     *
     * @return ArtistInterface|null
     */
    public function getArtistByMusicBrainzId($musicBrainzId = null);

    /**
     * @param  $artist
     * @param  $albumName
     *
     * @return object|null
     */
    public function getArtistAlbumByName($artist, $albumName);
}
