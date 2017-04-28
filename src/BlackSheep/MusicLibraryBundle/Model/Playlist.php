<?php

namespace BlackSheep\MusicLibraryBundle\Model;

/**
 *
 */
use BlackSheep\MusicLibraryBundle\Helper\PlaylistCoverHelper;

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
     * @var $string
     */
    protected $cover;

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

    /**
     * @inheritDoc
     */
    public function getAlbums()
    {
        $albums = [];
        foreach ($this->getSongs() as $song) {
            $albums[$song->getAlbum()->getSlug()] = $song->getAlbum();
        }
        return $albums;
    }

    /**
     * @return string
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * @param string $cover
     *
     * @return PlaylistInterface
     */
    public function setCover($cover)
    {
        $this->cover = $cover;

        return $this;
    }
}