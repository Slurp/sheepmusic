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
 * Class Artwork.
 */
class Artwork extends AbstractMedia implements ArtworkInterface
{
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
     * @param string $type
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getLikes(): int
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
