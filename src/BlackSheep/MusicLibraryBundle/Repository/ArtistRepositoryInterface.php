<?php
namespace BlackSheep\MusicLibraryBundle\Repository;

use BlackSheep\MusicLibraryBundle\Entity\ArtistsEntity;
use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;

/**
 * Interface ArtistRepositoryInterface
 *
 * @package BlackSheep\MusicLibraryBundle\Repository
 */
interface ArtistRepositoryInterface
{
    /**
     * @param      $artistName
     * @param null $musicBrainzId
     *
     * @return ArtistsEntity|null
     */
    public function addOrUpdate($artistName, $musicBrainzId = null);

    /**
     * @param ArtistsEntity $artistEntity
     *
     * @return ArtistsEntity
     */
    public function save(ArtistsEntity $artistEntity);

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
