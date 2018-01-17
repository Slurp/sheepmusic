<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibraryBundle\EventListener;

use BlackSheep\MusicLibraryBundle\Events\SongEventInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Interface SongEventListener.
 */
interface SongEventListener extends EventSubscriberInterface
{
    /**
     * @param SongEventInterface $songEvent;
     */
    public function playingSong(SongEventInterface $songEvent);

    /**
     * @param SongEventInterface $songEvent;
     */
    public function playedSong(SongEventInterface $songEvent);

    /**
     * @param SongEventInterface $songEvent;
     */
    public function lovedSong(SongEventInterface $songEvent);

    /**
     * @param SongEventInterface $songEvent;
     */
    public function ratedSong(SongEventInterface $songEvent);
}
