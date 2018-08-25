<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Model\Media;

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
    const TYPE_COVER = 'cover';
    const TYPE_CDART = 'cdart';

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
     * @return int
     */
    public function getLikes();

    /**
     * @param mixed $likes
     */
    public function setLikes($likes);
}
