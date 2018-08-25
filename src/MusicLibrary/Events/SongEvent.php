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

use BlackSheep\MusicLibrary\Model\SongInterface;
use Symfony\Component\EventDispatcher\Event;

class SongEvent extends Event implements SongEventInterface
{
    /**
     * @var SongInterface
     */
    protected $song;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @param SongInterface $song
     * @param null          $value
     */
    public function __construct(SongInterface $song, $value = null)
    {
        $this->song = $song;
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getSong()
    {
        return $this->song;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->song;
    }
}
