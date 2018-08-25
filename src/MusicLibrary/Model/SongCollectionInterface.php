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

/**
 * Interface SongCollectionInterface.
 */
interface SongCollectionInterface
{
    /**
     * @return SongInterface[]
     */
    public function getSongs();

    /**
     * @param SongInterface[] $songs
     *
     * @return array
     */
    public function setSongs($songs);

    /**
     * @param SongInterface $song
     *
     * @return $this
     */
    public function addSong(SongInterface $song);

    /**
     * @param SongInterface $song
     *
     * @return $this
     */
    public function removeSong(SongInterface $song);
}
