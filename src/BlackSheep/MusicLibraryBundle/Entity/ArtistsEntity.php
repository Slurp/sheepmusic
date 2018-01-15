<?php

namespace BlackSheep\MusicLibraryBundle\Entity;

use BlackSheep\MusicLibraryBundle\Model\Artist;
use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;
use BlackSheep\MusicLibraryBundle\Model\GenreInterface;
use BlackSheep\MusicLibraryBundle\Model\Media\ArtworkInterface;
use BlackSheep\MusicLibraryBundle\Model\SongInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="BlackSheep\MusicLibraryBundle\Repository\ArtistRepository")
 * @UniqueEntity("musicBrainzId")
 */
class ArtistsEntity extends Artist implements ArtistInterface
{
    use BaseEntity;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", unique=true)
     */
    protected $slug;

    /**
     * @Gedmo\Slug(handlers={
     *     @Gedmo\SlugHandler(class="Gedmo\Sluggable\Handler\InversedRelativeSlugHandler", options={
     *         @Gedmo\SlugHandlerOption(name="relationClass", value="Albums"),
     *         @Gedmo\SlugHandlerOption(name="mappedBy", value="albums"),
     *         @Gedmo\SlugHandlerOption(name="inverseSlugField", value="slug")
     *     })
     * }, fields={"name"})
     * @ORM\Column(type="string", unique=true)
     */
    protected $alias;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", nullable=true, unique=true)
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
     * @ORM\OneToMany(targetEntity="AlbumEntity", mappedBy="artist", fetch="EXTRA_LAZY")
     */
    protected $albums;

    /**
     * @ORM\ManyToMany(targetEntity="SongEntity", mappedBy="artists", fetch="EXTRA_LAZY")
     */
    protected $songs;

    /**
     * @ORM\ManyToMany(targetEntity="GenreEntity", fetch="EXTRA_LAZY")
     * @ORM\JoinTable(
     *     name="artists_genres",
     *     joinColumns={
     *         @ORM\JoinColumn(name="artist_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *         @ORM\JoinColumn(name="genre_id", referencedColumnName="id")
     *     }
     * )
     */
    protected $genres;

    /**
     * @ORM\OneToMany(
     *     targetEntity="BlackSheep\MusicLibraryBundle\Entity\Media\ArtworkEntity",
     *     mappedBy="artist",
     *     cascade={"all"}
     * )
     */
    protected $artworks;

    /**
     * @ORM\ManyToMany(targetEntity="BlackSheep\MusicLibraryBundle\Entity\ArtistsEntity", fetch="EXTRA_LAZY")
     * @ORM\JoinTable(
     *     name="artists_similar",
     *     joinColumns={
     *         @ORM\JoinColumn(name="artist_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *         @ORM\JoinColumn(name="similar_id", referencedColumnName="id")
     *     }
     * )
     */
    protected $similarArtists;

    public function __construct()
    {
        $this->albums = new ArrayCollection();
        $this->songs = new ArrayCollection();
        $this->genres = new ArrayCollection();
        $this->artworks = new ArrayCollection();
        $this->similarArtists = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function addSong(SongInterface $song): ArtistInterface
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
    public function removeSong(SongInterface $song): ArtistInterface
    {
        if ($this->songs->contains($song) === true) {
            $song->setAlbum(null);
            $this->songs->remove($song);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addGenre(GenreInterface $genre): ArtistInterface
    {
        if ($this->genres->contains($genre) === false) {
            $this->genres->add($genre);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeGenre(GenreInterface $genre): ArtistInterface
    {
        if ($this->genres->contains($genre) === true) {
            $this->genres->remove($genre);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addArtwork(ArtworkInterface $artwork): ArtistInterface
    {
        if ($this->artworks->contains($artwork) === false) {
            $this->artworks->add($artwork);
            $artwork->setArtist($this);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addSimilarArtist(ArtistInterface $similarArtist): ArtistInterface
    {
        if ($this->similarArtists->contains($similarArtist) === false) {
            $this->similarArtists->add($similarArtist);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeSimilarArtist(ArtistInterface $similarArtist): ArtistInterface
    {
        if ($this->similarArtists->contains($similarArtist) === true) {
            $this->similarArtists->remove($similarArtist);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getApiData(): array
    {
        $array = parent::getApiData();
        $array['id'] = $this->getId();

        return $array;
    }
}
