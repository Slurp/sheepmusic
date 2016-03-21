<?php
namespace BlackSheep\MusicLibraryBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;


/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="BlackSheep\MusicLibraryBundle\Repository\ArtistRepository")
 */
class Artists extends BaseEntity
{
    /**
     * @ORM\Column(nullable=false)
     */
    protected $name;

    /**
     * @ORM\Column(nullable=true)
     */
    protected $image;

    /**
     * @ORM\Column(nullable=true)
     */
    protected $playCount;

    /**
     * @ORM\OneToMany(targetEntity="Albums", mappedBy="artist",cascade={"all"})
     */
    protected $albums;

    /**
     * @ORM\ManyToMany(targetEntity="Songs", mappedBy="artists" , fetch="EXTRA_LAZY")
     */
    protected $songs;

    /**
     */
    public function __construct()
    {
        $this->albums = new ArrayCollection();
        $this->songs = new ArrayCollection();
    }

    /**
     * @param $name
     * @return Artists
     */
    public static function createNew($name)
    {
        $artist = new self();
        $artist->name = $name;
        return $artist;
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
     *
     * @return Artists
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     *
     * @return Artists
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAlbums()
    {
        return $this->albums;
    }

    /**
     * @param mixed $albums
     *
     * @return Artists
     */
    public function setAlbums($albums)
    {
        $this->albums = $albums;

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
     *
     * @return Artists
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
        }
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
     * @return Artists
     */
    public function setPlayCount($playCount)
    {
        $this->playCount = $playCount;
        return $this;
    }
}
