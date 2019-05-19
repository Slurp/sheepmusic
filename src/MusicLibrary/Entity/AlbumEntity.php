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
use BlackSheep\MusicLibrary\Entity\Media\AlbumArtworkEntityInterface;
use BlackSheep\MusicLibrary\Entity\Traits\ArtworkCollectionEntityTrait;
use BlackSheep\MusicLibrary\Model\Album;
use BlackSheep\MusicLibrary\Model\AlbumInterface;
use BlackSheep\MusicLibrary\Model\Media\ArtworkInterface;
use BlackSheep\MusicLibrary\Model\SongCollectionInterface;
use BlackSheep\MusicLibrary\Model\SongInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     shortName="Album",
 *     collectionOperations={
 *         "get"={
 *             "access_control"="is_granted('ROLE_USER')",
 *             "access_control_message"="Access to other users is forbidden.",
 *             "normalization_context"={"groups"={"collection","album_collection"}},
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
 * @ORM\Table(indexes={
 *     @ORM\Index(name="index_artist_album", columns={"artist_id", "name"}),
 *     @ORM\Index(name="index_create", columns={"created_at"}),
 *     @ORM\Index(name="index_update", columns={"updated_at"})
 * }))
 * @ORM\Entity(repositoryClass="BlackSheep\MusicLibrary\Repository\AlbumsRepository")
 * @UniqueEntity("musicBrainzId")
 *
 */
class AlbumEntity extends Album implements AlbumInterface
{
    use BaseEntity;
    use ArtworkCollectionEntityTrait;

    /**
     * @Groups({"album_collection"})
     * @Gedmo\Slug(handlers={
     *     @Gedmo\SlugHandler(class="Gedmo\Sluggable\Handler\RelativeSlugHandler", options={
     *         @Gedmo\SlugHandlerOption(name="relationField", value="artist"),
     *         @Gedmo\SlugHandlerOption(name="relationSlugField", value="alias"),
     *         @Gedmo\SlugHandlerOption(name="separator", value="/")
     *     })
     * }, separator="-", updatable=true, fields={"name"})
     * @ORM\Column(type="string", unique=true)
     */
    protected $slug;

    /**
     * @Groups({"album_collection"})
     * @ORM\Column(type="string", nullable=false)
     */
    protected $name;

    /**
     * @Groups({"album_collection"})
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $releaseDate;

    /**
     * @Groups({"album_collection"})
     * @ORM\Column(type="string", nullable=true)
     */
    protected $cover;

    /**
     * @Groups({"album_collection"})
     * @ORM\OneToMany(targetEntity="SongEntity", mappedBy="album", cascade={"all"})
     * @ORM\OrderBy({"track": "ASC"})
     */
    protected $songs;

    /**
     * @Groups({"album_collection"})
     * @ORM\ManyToOne(targetEntity="ArtistsEntity", inversedBy="albums", cascade={"all"})
     */
    protected $artist;

    /**
     * @ORM\Column(type="string", nullable=true, unique=true)
     */
    protected $musicBrainzId;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $musicBrainzReleaseGroupId;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $lastFmId;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $lastFmUrl;

    /**
     * @Groups({"album_collection"})
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $playCount;

    /**
     * @ORM\ManyToOne(targetEntity="BlackSheep\MusicLibrary\Entity\GenreEntity")
     */
    protected $genre;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $lossless = true;

    /**
     * @ORM\OneToMany(
     *     targetEntity="BlackSheep\MusicLibrary\Entity\Media\AlbumArtworkEntity",
     *     mappedBy="album",
     *     cascade={"all"}
     * )
     */
    protected $artworks;

    /**
     * Constructs this object with a array collection.
     */
    public function __construct()
    {
        $this->songs = new ArrayCollection();
        $this->artworks = new ArrayCollection();
        $this->lossless = true;
    }

    /**
     * {@inheritdoc}
     */
    public function addSong(SongInterface $song): SongCollectionInterface
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
    public function removeSong(SongInterface $song): SongCollectionInterface
    {
        if ($this->songs->contains($song)) {
            $this->songs->removeElement($song);
            $song->setAlbum(null);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addArtwork(ArtworkInterface $artwork): AlbumInterface
    {
        if ($this->artworks->contains($artwork) === false) {
            $this->artworks->add($artwork);
            if ($artwork instanceof AlbumArtworkEntityInterface) {
                $artwork->setAlbum($this);
            }
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
        $array['year'] = '....';
        if ($this->getSongs()->first()) {
            $array['year'] = $this->getSongs()->first()->getYear();
        }

        return $array;
    }
}
