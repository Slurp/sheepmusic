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

use BlackSheep\MusicLibrary\Model\ArtistInterface;

/**
 * ArtistEvent for when something happens with a artist.
 */
interface ArtistEventInterface
{
    const ARTIST_EVENT_FETCHED = 'artist_event_fetched';
    const ARTIST_EVENT_CREATED = 'artist_event_created';
    const ARTIST_EVENT_UPDATED = 'artist_event_updated';

    /**
     * @return ArtistInterface
     */
    public function getArtist(): ArtistInterface;
}
