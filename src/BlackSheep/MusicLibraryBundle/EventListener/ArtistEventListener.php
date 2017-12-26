<?php

namespace BlackSheep\MusicLibraryBundle\EventListener;

use BlackSheep\MusicLibraryBundle\Events\ArtistEventInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Interface ArtistEventListener
 *
 * @package BlackSheep\MusicLibraryBundle\EventListener
 */
interface ArtistEventListener extends EventSubscriberInterface
{
    /**
     * @param ArtistEventInterface $event;
     * @return void
     */
    public function fetchedArtist(ArtistEventInterface $event);

    /**
     * @param ArtistEventInterface $event;
     * @return void
     */
    public function updatedArtist(ArtistEventInterface $event);

    /**
     * @param ArtistEventInterface $event;
     * @return void
     */
    public function createdArtist(ArtistEventInterface $event);
}
