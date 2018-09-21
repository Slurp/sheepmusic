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

class Playlist implements PlaylistInterface, ApiInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
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
        if ($name === '' || $name === null) {
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
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function addSong(PlaylistsSongsInterface $song)
    {
        if (\in_array($song, $this->songs, true) === false) {
            $this->songs[] = $song;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function getApiData(): array
    {
        return [
            'cover' => $this->getCover(),
            'name' => $this->getName(),
        ];
    }
}
