<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Model\SimilarArtist;

use BlackSheep\MusicLibrary\Model\ArtistInterface;

/**
 * Interface SimilarArtistsInterface.
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
     * @return float
     */
    public function getMatch(): float;

    /**
     * @param float $match
     */
    public function setMatch(float $match);

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
