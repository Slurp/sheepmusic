<?php

namespace BlackSheep\MusicLibraryBundle\EventListener;

use BlackSheep\MusicLibraryBundle\Events\ArtistEventInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Interface ArtistEventListener.
 */
interface ArtistEventListener extends EventSubscriberInterface
{
    /**
     * @param ArtistEventInterface $event;
     */
    public function fetchedArtist(ArtistEventInterface $event);

    /**
     * @param ArtistEventInterface $event;
     */
    public function updatedArtist(ArtistEventInterface $event);

    /**
     * @param ArtistEventInterface $event;
     */
    public function createdArtist(ArtistEventInterface $event);
}
