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

use BlackSheep\MusicLibraryBundle\Model\SongInterface;

/**
 * SongEvent for when something happens with a song.
 */
interface SongEventInterface
{
    const SONG_EVENT_PLAYING = 'song_event_playing';
    const SONG_EVENT_PLAYED = 'song_event_played';
    const SONG_EVENT_LOVED = 'song_event_loved';
    const SONG_EVENT_RATED = 'song_event_rated';

    /**
     * @return SongInterface
     */
    public function getSong();
}
