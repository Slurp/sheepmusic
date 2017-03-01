<?php
namespace BlackSheep\MusicLibraryBundle\Entity;

use BlackSheep\MusicLibraryBundle\Model\Album;
use BlackSheep\MusicLibraryBundle\Model\AlbumInterface;
use BlackSheep\MusicLibraryBundle\Model\SongInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
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
     */
    public function __construct()
    {
        $this->songs = new ArrayCollection();
    }

    /**
     * @inheritdoc
     */
    public static function createArtistAlbum($name, $artist, $extraInfo)
    {
        $album = new self();
        $album->setName($name);
        $album->setArtist($artist);
        $album->setCover($extraInfo['cover']);
        $album->setMusicBrainzId($extraInfo['album_mbid']);
        return $album;
    }

    /**
     * @inheritdoc
     */
    public function addSong(SongInterface $song)
    {
        if ($this->songs->contains($song) === false) {
            $this->songs->add($song);
            $song->setAlbum($this);
        }

        return $this;
    }
}
