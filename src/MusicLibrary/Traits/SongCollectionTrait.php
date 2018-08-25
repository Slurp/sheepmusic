<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Traits;

use BlackSheep\MusicLibrary\Model\SongInterface;

/**
 * Trait SongCollectionTrait.
 */
trait SongCollectionTrait
{
    /**
     * @var SongInterface[]
     */
    protected $songs;

    /**
     * @return SongInterface[]
     */
    public function getSongs()
    {
        return $this->songs;
    }

    /**
     * {@inheritdoc}
     */
    public function setSongs($songs)
    {
        foreach ($songs as $song) {
            $this->addSong($song);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addSong(SongInterface $song)
    {
        if (in_array($song, $this->songs, true) === false) {
            $this->songs[] = $song;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeSong(SongInterface $song)
    {
        if (($key = array_search($song, $this->songs, true)) !== false) {
            unset($this->songs[$key]);
            $this->songs = array_values($this->songs);
        }

        return $this;
    }
}
