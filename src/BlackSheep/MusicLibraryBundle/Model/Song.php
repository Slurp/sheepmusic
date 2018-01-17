<?php

namespace BlackSheep\MusicLibraryBundle\Model;

use BlackSheep\MusicLibraryBundle\Traits\PlayCountTrait;

/**
 * Model for a Song.
 */
class Song implements SongInterface
{
    use PlayCountTrait;

    /**
     * @var string
     */
    protected $track;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var int
     */
    protected $length;

    /**
     * @var int
     */
    protected $mTime;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var AlbumInterface
     */
    protected $album;

    /**
     * @var PlaylistInterface[];
     */
    protected $playlists;

    /**
     * @var ArtistInterface[]
     */
    protected $artists;

    /**
     * {@inheritdoc}
     */
    public function addArtist(ArtistInterface $artist)
    {
        if (in_array($artist, $this->artists) === false) {
            $this->artists[] = $artist;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public static function createFromArray($songInfo)
    {
        $song = new static();
        $song->setTrack($songInfo['track']);
        $song->setTitle($songInfo['title']);
        $song->setLength($songInfo['length']);
        $song->setMTime($songInfo['mTime']);
        $song->setPath($songInfo['path']);

        return $song;
    }    /**
     * {@inheritdoc}
     */
    public function getTrack()
    {
        return $this->track;
    }

    /**
     * {@inheritdoc}
     */
    public function setTrack($track)
    {
        $this->track = $track;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * {@inheritdoc}
     */
    public function setLength($length)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMTime()
    {
        return $this->mTime;
    }

    /**
     * {@inheritdoc}
     */
    public function setMTime($mTime)
    {
        $this->mTime = $mTime;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAlbum()
    {
        return $this->album;
    }

    /**
     * {@inheritdoc}
     */
    public function setAlbum(AlbumInterface $album = null)
    {
        $this->album = $album;

        return $this;
    }


    /**
     * {@inheritdoc}
     */
    public function getPlaylists()
    {
        return $this->playlists;
    }

    /**
     * {@inheritdoc}
     */
    public function setPlaylists($playlists)
    {
        $this->playlists = $playlists;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function addPlaylist(PlaylistInterface $playlist)
    {
        $this->playlists[] = $playlist;
    }

    /**
     * @inheritDoc
     */
    public function removePlaylist(PlaylistInterface $playlist)
    {
        unset($playlist, $this->playlists);
    }

    /**
     * {@inheritdoc}
     */
    public function getArtist()
    {
        return $this->getArtists()[0];
    }

    /**
     * {@inheritdoc}
     */
    public function getArtists()
    {
        return $this->artists;
    }

    /**
     * {@inheritdoc}
     */
    public function setArtists($artists)
    {
        $this->artists = $artists;

        return $this;
    }



    /**
     * {@inheritdoc}
     */
    public function getApiData()
    {
        $apiData = [
            'track' => $this->getTrack(),
            'title' => $this->getTitle(),
            'length' => $this->getLength(),
            'playCount' => $this->getPlayCount(),
        ];
        if ($this->getArtist() instanceof ApiInterface) {
            $apiData['artist'] = $this->getArtist()->getApiData();
        }
        if ($this->getAlbum() instanceof ApiInterface) {
            $apiData['album'] = $this->getAlbum()->getApiData();
        }

        return $apiData;
    }
}
