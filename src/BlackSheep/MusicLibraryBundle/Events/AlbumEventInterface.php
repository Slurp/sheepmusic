<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibraryBundle\Events;

use BlackSheep\MusicLibraryBundle\Model\AlbumInterface;

/**
 * AlbumEvent for when something happens with a album.
 */
interface AlbumEventInterface
{
    const ALBUM_EVENT_FETCHED = 'album_event_fetched';
    const ALBUM_EVENT_CREATED = 'album_event_created';
    const ALBUM_EVENT_UPDATED = 'album_event_updated';

    /**
     * @return AlbumInterface
     */
    public function getAlbum();
}
