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
 * Class SimilarArtists.
 */
class SimilarArtists implements SimilarArtistsInterface
{
    /**
     * {@inheritdoc}
     */
    public static function createNew(ArtistInterface $artist, ArtistInterface $similar, $match)
    {
        $object = new static();
        $object->setArtist($artist);
        $object->setSimilar($similar);
        $object->setMatch($match);

        return $object;
    }

    /**
     * @var float
     */
    protected $match;

    /**
     * @var ArtistInterface
     */
    protected $artist;

    /**
     * @var ArtistInterface
     */
    protected $similar;

    /**
     * @return float
     */
    public function getMatch(): float
    {
        return $this->match;
    }

    /**
     * @param float $match
     */
    public function setMatch(float $match)
    {
        $this->match = $match;
    }

    /**
     * @return ArtistInterface
     */
    public function getArtist(): ArtistInterface
    {
        return $this->artist;
    }

    /**
     * @param ArtistInterface $artist
     */
    public function setArtist(ArtistInterface $artist)
    {
        $this->artist = $artist;
    }

    /**
     * @return ArtistInterface
     */
    public function getSimilar(): ArtistInterface
    {
        return $this->similar;
    }

    /**
     * @param ArtistInterface $similar
     */
    public function setSimilar(ArtistInterface $similar)
    {
        $this->similar = $similar;
    }
}
