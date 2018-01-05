<?php

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
