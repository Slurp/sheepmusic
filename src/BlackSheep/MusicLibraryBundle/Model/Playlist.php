<?php

namespace BlackSheep\MusicLibraryBundle\Model;

/**
 *
 */
class Playlist implements PlaylistInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $songs;

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
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
        $this->songs = $songs;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addSong(SongInterface $song)
    {
        $this->songs[] = $song;

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
