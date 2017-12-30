<?php

namespace BlackSheep\MusicLibraryBundle\Model;


/**
 *
 */
class Playlist implements PlaylistInterface, ApiInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string $cover
     */
    protected $cover;

    /**
     * @var array
     */
    protected $songs;

    /**
     * @param string|null $name
     *
     * @return PlaylistInterface
     */
    public static function create($name = null)
    {
        $playlist = new static();
        if ($name === "" || $name === null) {
            $date = new \DateTime();
            $name = $date->format(DATE_W3C);
        }
        $playlist->setName($name);
        $playlist->setSongs([]);

        return $playlist;
    }

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
     * @inheritDoc
     */
    public function getAlbums()
    {
        $albums = [];
        foreach ($this->getSongs() as $song) {
            $albums[$song->getSong()->getAlbum()->getSlug()] = $song->getSong()->getAlbum();
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

    /**
     * @return array
     */
    public function getSongs()
    {
        return $this->songs;
    }

    /**
     * @param array $songs
     */
    public function setSongs($songs)
    {
        $this->songs = $songs;
    }

    /**
     * @inheritDoc
     */
    public function addSong(PlaylistsSongsInterface $song)
    {
        if (in_array($song, $this->songs) === false) {
            $this->songs[] = $song;
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function removeSong(PlaylistsSongsInterface $song)
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
    public function getApiData()
    {
        return [
            'cover' => $this->getCover(),
            'name' => $this->getName()
        ];
    }
}
