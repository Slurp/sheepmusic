<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Model;

interface PlaylistsSongsInterface
{
    /**
     * @return int
     */
    public function getPosition();

    /**
     * @param int $position
     *
     * @return PlaylistsSongs
     */
    public function setPosition($position);

    /**
     * @return PlaylistInterface
     */
    public function getPlaylist();

    /**
     * @param PlaylistInterface $playlist
     */
    public function setPlaylist(PlaylistInterface $playlist);

    /**
     * @return SongInterface
     */
    public function getSong();

    /**
     * @param SongInterface $song
     */
    public function setSong(SongInterface $song);
}
