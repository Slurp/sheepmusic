<?php
namespace BlackSheep\MusicLibraryBundle\Entity;

use BlackSheep\MusicLibraryBundle\Services\LastFmService;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Filesystem\Filesystem;

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
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $releaseDate;

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

        $lastFmService = new LastFmService();
        $lastFmInfo    = $lastFmService->getAlbumInfo($album->getName(), $album->getArtist()->getName());
        $album->setMusicBrainzId($lastFmInfo['mbid']);
        $album->setLastFmId($lastFmInfo['lastfmid']);
        $album->setLastFmUrl($lastFmInfo['url']);
        if ($album->cover === null) {
            $album->setCover($lastFmInfo['image']['large']);
        }
        if ($lastFmInfo['releasedate'] !== false) {
            $album->setReleaseDate(new DateTime($lastFmInfo['releasedate']));
        }

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
        if (strpos($this->cover, 'http') !== 0) {
            return $this->getUploadDirectory() . $this->cover;
        }

        return $this->cover;
    }

    /**
     * @param mixed $cover
     * @return Albums
     */
    public function setCover($cover)
    {
        if (is_array($cover)) {
            $cover = $this->generateCover($cover);
        }
        $this->cover = $cover;

        return $this;
    }

    /**
     * Generate a cover from provided data.
     *
     * @param array $cover The cover data in array format, extracted by getID3.
     *                     For example:
     *                     [
     *                     'data' => '<binary data>',
     *                     'image_mime' => 'image/png',
     *                     'image_width' => 512,
     *                     'image_height' => 512,
     *                     'imagetype' => 'PNG', // not always present
     *                     'picturetype' => 'Other',
     *                     'description' => '',
     *                     'datalength' => 7627,
     *                     ]
     * @return string
     */
    public function generateCover(array $cover)
    {
        $extension = explode('/', $cover['image_mime']);
        $extension = empty($extension[1]) ? 'png' : $extension[1];

        return $this->writeCoverFile($cover['data'], $extension);
    }

    /**
     * Write a cover image file with binary data and update the Album with the new cover file.
     *
     * @param string $binaryData
     * @param string $extension The file extension
     * @return string
     */
    private function writeCoverFile($binaryData, $extension)
    {
        $extension = trim(strtolower($extension), '. ');
        $fileName  = uniqid() . ".$extension";
        $coverPath = $this->getUploadRootDirectory() . $fileName;
        $fs        = new Filesystem();
        $fs->dumpFile($coverPath, $binaryData);

        return $fileName;
    }

    /**
     * @return string
     */
    public function getUploadRootDirectory()
    {
        return $this->getWebDirectory() . $this->getUploadDirectory();
    }

    /**
     * @return string
     */
    public function getWebDirectory()
    {
        return __DIR__ . "/../../../../web";
    }

    /**
     * @return string
     */
    public function getUploadDirectory()
    {
        return "/uploads/" . $this->getArtist()->getName() . "/";
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
     * @return Artists
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

    /**
     * @return mixed
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * @param mixed $releaseDate
     * @return Albums
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;

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
     * @return Albums
     */
    public function setMusicBrainzId($musicBrainzId)
    {
        $this->musicBrainzId = $musicBrainzId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastFmId()
    {
        return $this->lastFmId;
    }

    /**
     * @param mixed $lastFmId
     * @return Albums
     */
    public function setLastFmId($lastFmId)
    {
        $this->lastFmId = $lastFmId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastFmUrl()
    {
        return $this->lastFmUrl;
    }

    /**
     * @param mixed $lastFmUrl
     * @return Albums
     */
    public function setLastFmUrl($lastFmUrl)
    {
        $this->lastFmUrl = $lastFmUrl;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastFmInfo()
    {
        $lastFmService = new LastFmService();

        return $lastFmService->getAlbumInfo($this->getName(), $this->getArtist()->getName());
    }
}
