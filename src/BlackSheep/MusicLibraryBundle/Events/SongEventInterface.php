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
