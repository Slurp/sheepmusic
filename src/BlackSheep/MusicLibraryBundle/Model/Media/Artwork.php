<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibraryBundle\Model\Media;

use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;

/**
 * Class Artwork.
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
