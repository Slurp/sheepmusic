<?php

namespace BlackSheep\MusicLibraryBundle\EventListener;

use BlackSheep\MusicLibraryBundle\Events\AlbumEventInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Interface AlbumEventListener.
 */
interface AlbumEventListener extends EventSubscriberInterface
{
    /**
     * @param AlbumEventInterface $event;
     */
    public function fetchedAlbum(AlbumEventInterface $event);

    /**
     * @param AlbumEventInterface $event;
     */
    public function updatedAlbum(AlbumEventInterface $event);

    /**
     * @param AlbumEventInterface $event;
     */
    public function createdAlbum(AlbumEventInterface $event);
}
