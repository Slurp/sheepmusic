<?php

namespace BlackSheep\MusicLibraryBundle\Model;

use Symfony\Component\Filesystem\Filesystem;

/**
 * Define a Album.
 */
class Album implements AlbumInterface
{
    /**
     * @var string
     */
    protected $slug;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $releaseDate;

    /**
     * @var string
     */
    protected $cover;

    /**
     * @var SongInterface[]
     */
    protected $songs;

    /**
     * @var ArtistInterface
     */
    protected $artist;

    /**
     * @var string
     */
    protected $musicBrainzId;

    /**
     * @var string
     */
    protected $lastFmId;



    /**
     * @var string
     */
    protected $lastFmUrl;

    /**
     * @param $name
     * @param $artist
     * @param $extraInfo
     *
     * @return AlbumInterface
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
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCover()
    {
        if (strpos($this->cover, 'http') !== 0 && $this->cover !== null) {
            return $this->getUploadDirectory() . $this->cover;
        }

        return $this->cover;
    }

    /**
     * {@inheritdoc}
     */
    public function setCover($cover)
    {
        if (is_array($cover)) {
            $cover = $this->generateCover($cover);
        }
        if (is_string($cover)) {
            $this->cover = $cover;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
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
     *
     * @return string
     */
    private function writeCoverFile($binaryData, $extension)
    {
        $extension = trim(strtolower($extension), '. ');
        $fileName = uniqid() . ".$extension";
        $coverPath = $this->getUploadRootDirectory() . $fileName;
        $fs = new Filesystem();
        $fs->dumpFile($coverPath, $binaryData);

        return $fileName;
    }

    /**
     * {@inheritdoc}
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
        return __DIR__ . '/../../../../web';
    }

    /**
     * @return string
     */
    public function getUploadDirectory()
    {
        return '/uploads/' . $this->getArtist()->getSlug() . '/';
    }

    /**
     * @return SongInterface[]
     */
    public function getSongs()
    {
        return $this->songs;
    }

    /**
     * {@inheritdoc}
     */
    public function setSongs($songs)
    {
        $this->songs = $songs;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addSong(SongInterface $song)
    {
        if (in_array($song, $this->songs) === false) {
            $this->songs[] = $song;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * {@inheritdoc}
     */
    public function setArtist($artists)
    {
        $this->artist = $artists;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * {@inheritdoc}
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMusicBrainzId()
    {
        return $this->musicBrainzId;
    }

    /**
     * {@inheritdoc}
     */
    public function setMusicBrainzId($musicBrainzId)
    {
        if (is_array($musicBrainzId)) {
            $musicBrainzId = $musicBrainzId[0];
        }
        $this->musicBrainzId = $musicBrainzId;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastFmId()
    {
        return $this->lastFmId;
    }

    /**
     * {@inheritdoc}
     */
    public function setLastFmId($lastFmId)
    {
        $this->lastFmId = $lastFmId;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastFmUrl()
    {
        return $this->lastFmUrl;
    }

    /**
     * {@inheritdoc}
     */
    public function setLastFmUrl($lastFmUrl)
    {
        $this->lastFmUrl = $lastFmUrl;

        return $this;
    }

    /**
     * @return array
     */
    public function getApiData()
    {
        return [
            'name' => $this->getName(),
            'cover' => $this->getCover(),
        ];
    }
}
