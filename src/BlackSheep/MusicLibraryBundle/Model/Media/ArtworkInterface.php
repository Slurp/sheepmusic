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
 * Interface ArtworkInterface.
 *
 * @ORM\Table
 * @ORM\Entity
 */
interface ArtworkInterface
{
    const TYPE_LOGO = 'logo';
    const TYPE_BANNER = 'banner';
    const TYPE_BACKGROUND = 'background';
    const TYPE_THUMBS = 'thumbs';

    /**
     * Artwork constructor.
     *
     * @param $type
     */
    public function __construct($type);

    /**
     * @return string
     */
    public function getType();

    /**
     * @return ArtistInterface
     */
    public function getArtist();

    /**
     * @param ArtistInterface $artist
     *
     * @return $this
     */
    public function setArtist(ArtistInterface $artist);

    /**
     * @return int
     */
    public function getLikes();

    /**
     * @param mixed $likes
     */
    public function setLikes($likes);
}
