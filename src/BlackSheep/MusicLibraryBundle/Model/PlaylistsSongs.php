<?php

namespace BlackSheep\MusicLibraryBundle\Model;

/**
 * Class PlaylistsSongs.
 */
class PlaylistsSongs implements PlaylistsSongsInterface
{
    /**
     * @var int
     */
    protected $position;

    /**
     * @var PlaylistInterface
     */
    protected $playlist;

    /**
     * @var SongInterface
     */
    protected $song;

    /**
     * {@inheritdoc}
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * {@inheritdoc}
     */
    public function setPosition($position): PlaylistsSongsInterface
    {
        $this->position = $position;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPlaylist(): PlaylistInterface
    {
        return $this->playlist;
    }

    /**
     * {@inheritdoc}
     */
    public function setPlaylist(PlaylistInterface $playlist)
    {
        $this->playlist = $playlist;
    }

    /**
     * {@inheritdoc}
     */
    public function getSong(): SongInterface
    {
        return $this->song;
    }

    /**
     * {@inheritdoc}
     */
    public function setSong(SongInterface $song)
    {
        $this->song = $song;
    }
}
