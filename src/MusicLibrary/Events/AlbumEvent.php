<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Events;

use BlackSheep\MusicLibrary\Model\AlbumInterface;
use Symfony\Contracts\EventDispatcher\Event;

class AlbumEvent extends Event implements AlbumEventInterface
{
    /**
     * @var AlbumInterface
     */
    protected $album;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @param AlbumInterface $album
     * @param null           $value
     */
    public function __construct(AlbumInterface $album, $value = null)
    {
        $this->album = $album;
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getAlbum()
    {
        return $this->album;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->album;
    }
}
