<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibraryBundle\Model;

use BlackSheep\MusicLibraryBundle\Helper\AlbumCoverHelper;
use BlackSheep\MusicLibraryBundle\Model\Media\ArtworkInterface;
use BlackSheep\MusicLibraryBundle\Traits\ArtworkCollectionTrait;
use BlackSheep\MusicLibraryBundle\Traits\HasGenreTrait;
use BlackSheep\MusicLibraryBundle\Traits\PlayCountTrait;
use BlackSheep\MusicLibraryBundle\Traits\SongCollectionTrait;

/**
 * Define a Album.
 */
class Album implements AlbumInterface
{
    use SongCollectionTrait;
    use PlayCountTrait;
    use HasGenreTrait;
    use ArtworkCollectionTrait;

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
    protected $musicBrainzReleaseGroupId;

    /**
     * @var string
     */
    protected $lastFmId;

    /**
     * @var string
     */
    protected $lastFmUrl;

    /**
     * @var int
     */
    protected $playCount;

    /**
     * @var bool
     */
    protected $lossless;

    /**
     * @param $name
     * @param ArtistInterface $artist
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
        if (isset($extraInfo['album_mbid']) && empty($extraInfo['album_mbid']) === false) {
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
        if (count($this->getArtworkCover()) !== 0) {
            return '/uploads/album/' . $this->getArtworkCover()[0]->getImage()->getName();
        }
        if (mb_strpos($this->cover, 'http') !== 0 && $this->cover !== null) {
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
    public function setArtist(ArtistInterface $artist)
    {
        $this->artist = $artist;

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
    public function getMusicBrainzReleaseGroupId()
    {
        return $this->musicBrainzReleaseGroupId;
    }

    /**
     * {@inheritdoc}
     */
    public function setMusicBrainzReleaseGroupId(string $musicBrainzReleaseGroupId)
    {
        $this->musicBrainzReleaseGroupId = $musicBrainzReleaseGroupId;
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
     * @return bool
     */
    public function isLossless()
    {
        return $this->lossless;
    }

    /**
     * @param bool $lossless
     */
    public function setLossless($lossless)
    {
        $this->lossless = $lossless;
    }

    /**
     * {@inheritdoc}
     */
    public function getCdArt(): array
    {
        return $this->filterArtwork(ArtworkInterface::TYPE_CDART);
    }

    /**
     * {@inheritdoc}
     */
    public function getArtworkCover(): array
    {
        return $this->filterArtwork(ArtworkInterface::TYPE_COVER);
    }

    /**
     * @return array
     */
    public function getApiData(): array
    {
        return [
            'slug' => $this->getSlug(),
            'name' => $this->getName(),
            'cover' => $this->getCover(),
            'playCount' => $this->getPlayCount(),
            'mbId' => $this->getMusicBrainzId(),
            'lossless' => $this->isLossless(),
        ];
    }
}
