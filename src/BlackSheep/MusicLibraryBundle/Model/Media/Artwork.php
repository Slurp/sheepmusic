<?php

namespace BlackSheep\MusicLibraryBundle\Model\Media;

use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;

/**
 * Class Artwork
 *
 * @package BlackSheep\MusicLibraryBundle\Entity\Media
 */
class Artwork extends AbstractMedia implements ArtworkInterface
{
    /**
     * @var ArtistInterface
     */
    protected $artist;

    /**
     * @var int
     */
    protected $likes;

    /**
     * @var string
     */
    protected $type;

    /**
     * Artwork constructor.
     *
     * @param $type
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }


    /**
     * {@inheritdoc}
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * {@inheritdoc}
     */
    public function setArtist(ArtistInterface $artist)
    {
        $this->artist = $artist;

        return $this;
    }

    /**
     * @return int
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * @param mixed $likes
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;
    }
}
