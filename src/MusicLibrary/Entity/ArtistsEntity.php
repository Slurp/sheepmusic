<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use BlackSheep\MusicLibrary\Entity\Media\ArtistArtworkEntityInterface;
use BlackSheep\MusicLibrary\Entity\Traits\ArtworkCollectionEntityTrait;
use BlackSheep\MusicLibrary\Model\Artist;
use BlackSheep\MusicLibrary\Model\ArtistInterface;
use BlackSheep\MusicLibrary\Model\GenreInterface;
use BlackSheep\MusicLibrary\Model\Media\ArtworkInterface;
use BlackSheep\MusicLibrary\Model\SimilarArtist\SimilarArtistsInterface;
use BlackSheep\MusicLibrary\Model\SongInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ApiResource(
 *     shortName="Artist",
 *     collectionOperations={
 *         "get"={
 *             "access_control"="is_granted('ROLE_USER')",
 *             "access_control_message"="Access to other users is forbidden."
 *         },
 *     },
 *     itemOperations={
 *         "get"={
 *             "access_control"="is_granted('ROLE_USER')",
 *             "access_control_message"="Access to other users is forbidden."
 *         },
 *     }
 * )
 *
 * @ORM\Entity(repositoryClass="BlackSheep\MusicLibrary\Repository\ArtistRepository")
 * @UniqueEntity("musicBrainzId")
 */
class ArtistsEntity extends Artist implements ArtistInterface
{
    use BaseEntity;
    use ArtworkCollectionEntityTrait;

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
     *     targetEntity="BlackSheep\MusicLibrary\Entity\Media\ArtistArtworkEntity",
     *     mappedBy="artist",
     *     cascade={"all"}
     * )
     */
    protected $artworks;

    /**
     * @ORM\OneToMany(
     *     targetEntity="BlackSheep\MusicLibrary\Entity\SimilarArtist\SimilarArtistEntity",
     *     mappedBy="artist",
     *     fetch="EXTRA_LAZY",
     *     cascade={"all"}
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
            $this->songs->removeElement($song);
            $song->setAlbum(null);
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
            $this->genres->removeElement($genre);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addArtwork(ArtworkInterface $artwork): ArtistInterface
    {
        if ($this->artworks->contains($artwork) === false) {
            if ($artwork instanceof ArtistArtworkEntityInterface) {
                $artwork->setArtist($this);
            }
            $this->artworks->add($artwork);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addSimilarArtist(SimilarArtistsInterface $similarArtist): ArtistInterface
    {
        if ($this->similarArtists->contains($similarArtist) === false) {
            $this->similarArtists->add($similarArtist);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeSimilarArtist(SimilarArtistsInterface $similarArtist): ArtistInterface
    {
        if ($this->similarArtists->contains($similarArtist) === true) {
            $this->similarArtists->removeElement($similarArtist);
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
