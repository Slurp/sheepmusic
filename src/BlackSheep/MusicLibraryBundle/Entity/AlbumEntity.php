<?php

namespace BlackSheep\MusicLibraryBundle\Entity;

use BlackSheep\MusicLibraryBundle\Model\Album;
use BlackSheep\MusicLibraryBundle\Model\AlbumInterface;
use BlackSheep\MusicLibraryBundle\Model\SongInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(indexes={
 *     @ORM\Index(name="index_artist_album", columns={"artist_id","name"}),
 *     @ORM\Index(name="index_create", columns={"created_at"}),
 *     @ORM\Index(name="index_update", columns={"updated_at"})
 * }))
 * @ORM\Entity(repositoryClass="BlackSheep\MusicLibraryBundle\Repository\AlbumsRepository")
 */
class AlbumEntity extends Album implements AlbumInterface
{
    use BaseEntity;

    /**
     * @Gedmo\Slug(handlers={
     *      @Gedmo\SlugHandler(class="Gedmo\Sluggable\Handler\RelativeSlugHandler", options={
     *          @Gedmo\SlugHandlerOption(name="relationField", value="artist"),
     *          @Gedmo\SlugHandlerOption(name="relationSlugField", value="alias"),
     *          @Gedmo\SlugHandlerOption(name="separator", value="/")
     *      })
     * }, separator="-", updatable=true, fields={"name"})
     * @ORM\Column(type="string", unique=true)
     */
    protected $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $releaseDate;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $cover;

    /**
     * @ORM\OneToMany(targetEntity="SongEntity", mappedBy="album",cascade={"all"})
     * @ORM\OrderBy({"track" = "ASC"})
     */
    protected $songs;

    /**
     * @ORM\ManyToOne(targetEntity="ArtistsEntity", inversedBy="albums",cascade={"all"})
     */
    protected $artist;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $musicBrainzId;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $lastFmId;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $lastFmUrl;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $playCount;

    /**
     * @ORM\ManyToOne(targetEntity="BlackSheep\MusicLibraryBundle\Entity\GenreEntity")
     */
    protected $genre;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $lossless = true;

    /**
     * Constructs this object with a array collection.
     */
    public function __construct()
    {
        $this->songs = new ArrayCollection();
        $this->lossless = true;
    }

    /**
     * {@inheritdoc}
     */
    public function addSong(SongInterface $song)
    {
        if ($this->songs->contains($song) === false) {
            $this->songs->add($song);
            $this->lossless = ($song->getAudio()->getLossless() === true && $this->lossless === true);
            $song->setAlbum($this);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getApiData()
    {
        $array = parent::getApiData();
        $array['id'] = $this->getId();
        $array['year'] = '....';
        if ($this->getSongs()->first()) {
            $array['year'] = $this->getSongs()->first()->getYear();
        }

        return $array;
    }
}
