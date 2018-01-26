<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibraryBundle\Repository;

use BlackSheep\MusicLibraryBundle\Model\PlaylistsSongs;
use BlackSheep\MusicLibraryBundle\Model\SongInterface;

/**
 * interface PlaylistsSongsRepositoryInterface.
 */
interface PlaylistsSongsRepositoryInterface
{
    /**
     * @param SongInterface $song
     *
     * @return PlaylistsSongs[]|null
     */
    public function findPlaylistsForSong(SongInterface $song);
}
