<?php

namespace BlackSheep\MusicLibraryBundle\Entity;

use BlackSheep\MusicLibraryBundle\Model\Artist;
use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;
use BlackSheep\MusicLibraryBundle\Model\GenreInterface;
use BlackSheep\MusicLibraryBundle\Model\Media\LogoInterface;
use BlackSheep\MusicLibraryBundle\Model\SongInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="BlackSheep\MusicLibraryBundle\Repository\ArtistRepository")
 */
class ArtistsEntity extends Artist implements ArtistInterface
{
    use BaseEntity;

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
     * @ORM\Column(type="text", nullable=true)
     */
    protected $biography;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $playCount;

    /**
     * @ORM\OneToMany(targetEntity="AlbumEntity", mappedBy="artist" , fetch="EXTRA_LAZY")
     */
    protected $albums;

    /**
     * @ORM\ManyToMany(targetEntity="SongEntity", mappedBy="artists" , fetch="EXTRA_LAZY")
     */
    protected $songs;

    /**
     * @ORM\ManyToMany(targetEntity="GenreEntity", fetch="EXTRA_LAZY")
     * @ORM\JoinTable(
     *  name="artists_genres",
     *  joinColumns={
     *      @ORM\JoinColumn(name="artist_id", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="genre_id", referencedColumnName="id")
     *  }
     * )
     */
    protected $genres;

    /**
     * @ORM\OneToMany(targetEntity="BlackSheep\MusicLibraryBundle\Entity\Media\LogoEntity", mappedBy="artist" ,cascade={"all"})
     */
    protected $logos;

    public function __construct()
    {
        $this->albums = new ArrayCollection();
        $this->songs = new ArrayCollection();
        $this->genres = new ArrayCollection();
        $this->logos = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function addSong(SongInterface $song)
    {
        if ($this->songs->contains($song) === false) {
            $this->songs->add($song);
            $song->setAlbum($this);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addGenre(GenreInterface $genre)
    {
        if ($this->genres->contains($genre) === false) {
            $this->logos->add($genre);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addLogo(LogoInterface $logo)
    {
        if ($this->logos->contains($logo) === false) {
            $this->logos->add($logo);
            $logo->setArtist($this);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getApiData()
    {
        $array = parent::getApiData();
        $array['id'] = $this->getId();

        return $array;
    }
}
