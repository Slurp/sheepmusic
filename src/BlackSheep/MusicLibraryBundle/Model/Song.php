<?php

namespace BlackSheep\MusicLibraryBundle\Model;

use BlackSheep\MusicLibraryBundle\Traits\HasGenreTrait;
use BlackSheep\MusicLibraryBundle\Traits\PlayCountTrait;

/**
 * Model for a Song.
 */
class Song implements SongInterface
{
    use PlayCountTrait;
    use HasGenreTrait;

    /**
     * @var string
     */
    protected $track;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var \DateTime
     */
    protected $year;

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
     * @var SongAudioInfoInterface
     */
    protected $audio;

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
        $song->setYear($songInfo['year']);
        if (isset($songInfo['audio'])) {
            $song->setAudio(new SongAudioInfo($songInfo['audio']));
        }

        return $song;
    }

    /**
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
    public function getYear()
    {
        return $this->year;
    }

    /**
     * {@inheritdoc}
     */
    public function setYear($year)
    {
        $this->year = $year;

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
     * {@inheritdoc}
     */
    public function addPlaylist(PlaylistInterface $playlist)
    {
        $this->playlists[] = $playlist;
    }

    /**
     * {@inheritdoc}
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
    public function getAudio()
    {
        return $this->audio;
    }

    /**
     * {@inheritdoc}
     */
    public function setAudio(SongAudioInfoInterface $audio)
    {
        $this->audio = $audio;
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
