<?php
namespace BlackSheep\MusicLibraryBundle\Entity;

use BlackSheep\MusicLibraryBundle\Services\LastFmService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="BlackSheep\MusicLibraryBundle\Repository\ArtistRepository")
 */
class Artists extends BaseEntity
{
    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string" , unique=true)
     */
    protected $slug;

    /**
     * @Gedmo\Slug(handlers={
     *      @Gedmo\SlugHandler(class="Gedmo\Sluggable\Handler\InversedRelativeSlugHandler", options={
     *          @Gedmo\SlugHandlerOption(name="relationClass", value="Albums"),
     *          @Gedmo\SlugHandlerOption(name="mappedBy", value="albums"),
     *          @Gedmo\SlugHandlerOption(name="inverseSlugField", value="slug")
     *      })
     * }, fields={"name"})
     * @ORM\Column(type="string" , unique=true)
     */
    protected $alias;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $musicBrainzId;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $image;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $biography;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $playCount;

    /**
     * @ORM\OneToMany(targetEntity="Albums", mappedBy="artist",cascade={"all"} , fetch="EXTRA_LAZY")
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
        $this->songs  = new ArrayCollection();
    }

    /**
     * @param      $name
     * @param null $musicBrainzId
     * @return Artists
     */
    public static function createNew($name, $musicBrainzId = null)
    {
        $artist = new self();
        $artist->setName($name);
        $artist->setMusicBrainzId($musicBrainzId);
        $lastFmService = new LastFmService();
        $lastFmInfo    = $lastFmService->getArtistInfo($artist->name);
        if ($artist->musicBrainzId !== null) {
            $artist->setMusicBrainzId($lastFmInfo['mbid']);
        }
        $artist->setImage($lastFmInfo['image']['large']);
        $artist->setPlayCount(0);
        $artist->setBiography($lastFmInfo['bio']['summary']);

        return $artist;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return mixed
     */
    public function getAlias()
    {
        return $this->alias;
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
    public function getMusicBrainzId()
    {
        return $this->musicBrainzId;
    }

    /**
     * @param mixed $musicBrainzId
     * @return Artists
     */
    public function setMusicBrainzId($musicBrainzId)
    {
        $this->musicBrainzId = $musicBrainzId;

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
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * @param mixed $biography
     * @return Artists
     */
    public function setBiography($biography)
    {
        $this->biography = $biography;

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

    /**
     * @return mixed
     */
    public function getLastFmInfo()
    {
        $lastFmService = new LastFmService();

        return $lastFmService->getArtistInfo($this->getName());
    }

    /**
     * @return mixed
     */
    public function getAlbumArt()
    {
        /** @var Albums $album */
        foreach ($this->getAlbums() as $album) {
            if ($album->getCover() !== null) {
                return $album->getCover();
            }
        }
    }
}
