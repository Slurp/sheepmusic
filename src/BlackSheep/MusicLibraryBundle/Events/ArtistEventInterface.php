<?php

namespace BlackSheep\MusicLibraryBundle\Events;

use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;

/**
 * ArtistEvent for when something happens with a artist
 */
interface ArtistEventInterface
{
    const ARTIST_EVENT_FETCHED = 'artist_event_fetched';
    const ARTIST_EVENT_CREATED = 'artist_event_created';
    const ARTIST_EVENT_UPDATED = 'artist_event_updated';

    /**
     * @return ArtistInterface
     */
    public function getArtist();
}
