<?php

namespace BlackSheep\MusicLibraryBundle\Model\SimilarArtist;

use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;

/**
 * Interface SimilarArtistsInterface
 *
 * @package BlackSheep\MusicLibraryBundle\Model\SimilarArtist
 */
interface SimilarArtistsInterface
{
    /**
     * @param ArtistInterface $artist
     * @param ArtistInterface $similar
     * @param $match
     *
     * @return mixed
     */
    public static function createNew(ArtistInterface $artist, ArtistInterface $similar, $match);


    /**
     * @return int
     */
    public function getMatch(): int;

    /**
     * @param int $match
     */
    public function setMatch(int $match);

    /**
     * @return ArtistInterface
     */
    public function getArtist(): ArtistInterface;

    /**
     * @param ArtistInterface $artist
     */
    public function setArtist(ArtistInterface $artist);

    /**
     * @return ArtistInterface
     */
    public function getSimilar(): ArtistInterface;

    /**
     * @param ArtistInterface $similar
     */
    public function setSimilar(ArtistInterface $similar);
}
