<?php
namespace BlackSheep\MusicLibraryBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="BlackSheep\MusicLibraryBundle\Repository\AlbumsRepository")
 */
class Albums extends BaseEntity
{
    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $cover;

    /**
     * @ORM\OneToMany(targetEntity="Songs", mappedBy="album",cascade={"all"})
     */
    protected $songs;

    /**
     * @ORM\ManyToOne(targetEntity="Artists", inversedBy="albums",cascade={"all"})
     */
    protected $artist;


    /**
     */
    public function __construct()
    {
        $this->songs = new ArrayCollection();
    }

    /**
     * @param $name
     * @param $artist
     * @param $cover
     * @return Albums
     */
    public static function createArtistAlbum($name, $artist, $cover)
    {
        $album = new self();
        $album->setName($name);
        $album->setArtist($artist);
        $album->setCover($cover);
        return $album;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Albums
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * @param mixed $cover
     * @return Albums
     */
    public function setCover($cover)
    {
        $this->cover = $cover;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSongs()
    {
        return $this->songs;
    }

    /**
     * @param mixed $songs
     * @return Albums
     */
    public function setSongs($songs)
    {
        $this->songs = $songs;
        return $this;
    }

    /**
     * @param Songs $song
     * @return Albums
     */
    public function addSong(Songs $song)
    {
        if ($this->songs->contains($song) === false) {
            $this->songs->add($song);
            $song->setAlbum($this);
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * @param mixed $artists
     * @return Albums
     */
    public function setArtist($artists)
    {
        $this->artist = $artists;
        return $this;
    }
}
