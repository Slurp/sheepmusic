<?php
namespace BlackSheep\MusicLibraryBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="BlackSheep\MusicLibraryBundle\Repository\SongsRepository")
 */
class Songs extends BaseEntity
{
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $track;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $title;

    /**
     * @ORM\Column(type="bigint", nullable=true)
     */
    protected $length;

    /**
     * @ORM\Column(type="bigint")
     */
    protected $mTime;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, unique=true)
     */
    protected $path;

    /**
     * @ORM\ManyToOne(targetEntity="Albums", inversedBy="songs")
     */
    protected $album;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $playCount;

    /**
     * @ORM\ManyToMany(targetEntity="Playlist", inversedBy="songs")
     * @ORM\JoinTable(
     *     name="PlaylistSongs",
     *     joinColumns={@ORM\JoinColumn(name="songs_id", referencedColumnName="id", nullable=true)},
     *     inverseJoinColumns={@ORM\JoinColumn(name="playlist_id", referencedColumnName="id", nullable=true)}
     * )
     */
    protected $playlist;

    /**
     * @ORM\ManyToMany(targetEntity="Artists", inversedBy="songs")
     * @ORM\JoinTable(
     *     name="ArtistSongs",
     *     joinColumns={@ORM\JoinColumn(name="songs_id", referencedColumnName="id", nullable=true)},
     *     inverseJoinColumns={@ORM\JoinColumn(name="artists_id", referencedColumnName="id", nullable=true)}
     * )
     */
    protected $artists;

    /**
     *
     */
    public function __construct()
    {
        $this->artists = new ArrayCollection();
    }

    /**
     * @param $songInfo
     * @return Songs
     */
    public static function createFromArray($songInfo)
    {
        $song = new self();
        $song->setTrack($songInfo['track']);
        $song->setTitle($songInfo['title']);
        $song->setLength($songInfo['length']);
        $song->setMTime($songInfo['mTime']);
        $song->setPath($songInfo['path']);

        return $song;
    }

    /**
     * @return mixed
     */
    public function getTrack()
    {
        return $this->track;
    }

    /**
     * @param mixed $track
     * @return Songs
     */
    public function setTrack($track)
    {
        $this->track = $track;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return Songs
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param mixed $length
     * @return Songs
     */
    public function setLength($length)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMTime()
    {
        return $this->mTime;
    }

    /**
     * @param mixed $mTime
     * @return Songs
     */
    public function setMTime($mTime)
    {
        $this->mTime = $mTime;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     * @return Songs
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAlbum()
    {
        return $this->album;
    }

    /**
     * @param mixed $album
     * @return Songs
     */
    public function setAlbum($album)
    {
        $this->album = $album;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPlayCount()
    {
        return $this->playCount;
    }

    /**
     * @param mixed $playCount
     * @return Songs
     */
    public function setPlayCount($playCount)
    {
        $this->playCount = $playCount;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPlaylist()
    {
        return $this->playlist;
    }

    /**
     * @param mixed $playlist
     * @return Songs
     */
    public function setPlaylist($playlist)
    {
        $this->playlist = $playlist;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getArtists()
    {
        return $this->artists;
    }

    /**
     * @param mixed $artists
     * @return Songs
     */
    public function setArtists($artists)
    {
        $this->artists = $artists;

        return $this;
    }

    /**
     * @param Artists $artist
     * @return $this
     */
    public function addArtist(Artists $artist)
    {
        if ($this->artists->contains($artist) === false) {
            $this->artists->add($artist);
        }

        return $this;
    }
}