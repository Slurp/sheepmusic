<?php
/**
 * @author: @{USER} <stephan@bureaublauwgeel.nl>
 * Date: 03/03/17
 * Time: 01:02
 *
 * @copyright 2017 Bureau Blauwgeel
 *
 * @version 1.0
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
