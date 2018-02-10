<?php

namespace BlackSheep\MusicLibraryBundle\Model\SimilarArtist;

use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;

/**
 * Class SimilarArtists
 *
 * @package BlackSheep\MusicLibraryBundle\Model\SimilarArtist
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
     * @var int
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
     * @return int
     */
    public function getMatch(): int
    {
        return $this->match;
    }

    /**
     * @param int $match
     */
    public function setMatch(int $match)
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
