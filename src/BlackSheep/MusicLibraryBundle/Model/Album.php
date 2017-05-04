<?php

namespace BlackSheep\MusicLibraryBundle\Model;

use BlackSheep\MusicLibraryBundle\Helper\AlbumCoverHelper;
use BlackSheep\MusicLibraryBundle\Traits\PlayCountTrait;
use BlackSheep\MusicLibraryBundle\Traits\SongCollectionTrait;

/**
 * Define a Album.
 */
class Album implements AlbumInterface
{
    use SongCollectionTrait;
    use PlayCountTrait;

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
     * @var integer
     */
    protected $playCount;

    /**
     * @param $name
     * @param \BlackSheep\MusicLibraryBundle\Entity\ArtistsEntity $artist
     * @param $extraInfo
     *
     * @return AlbumInterface
     */
    public static function createArtistAlbum($name, $artist, $extraInfo)
    {
        $album = new static();
        $album->setName($name);
        $album->setArtist($artist);
        if (isset($extraInfo['cover'])) {
            $album->setCover($extraInfo['cover']);
        }
        if (isset($extraInfo['album_mbid'])) {
            $album->setMusicBrainzId($extraInfo['album_mbid']);
        }

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
            return AlbumCoverHelper::getUploadDirectory() . $this->getArtist()->getSlug() . '/' . $this->cover;
        }

        return $this->cover;
    }

    /**
     * {@inheritdoc}
     */
    public function setCover($cover)
    {
        if (is_array($cover)) {
            $helper = new AlbumCoverHelper();
            $helper->generateCover($this, $cover);
        }
        if (is_string($cover)) {
            $this->cover = $cover;
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
