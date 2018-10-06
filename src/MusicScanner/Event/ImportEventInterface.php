<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicScanner\Event;

/**
 * AlbumEvent for when something happens with a album.
 */
interface ImportEventInterface
{
    const IMPORTED_STARTED = 'import_started';
    const IMPORTED_SONG = 'import_song';
    const IMPORTED_NEW_ALBUM = 'import_new_album';
    const IMPORTED_COMPLETE = 'import_complete';
    const IMPORTED_FAILURE = 'import_failure';
}
