<?php

namespace BlackSheep\MusicLibraryBundle\LastFm;

use BlackSheep\LastFmBundle\Info\LastFmAlbumInfo;
use BlackSheep\MusicLibraryBundle\Model\AlbumInterface;
use DateTime;

class LastFmAlbum implements LastFmAlbumInterface
{
    /**
     * @var LastFmAlbumInfo
     */
    protected $lastFmAlbumInfo;

    /**
     * @var AlbumInterface
     */
    protected $album;

    /**
     * @param LastFmAlbumInfo $lastFmAlbumInfo
     */
    public function __construct(LastFmAlbumInfo $lastFmAlbumInfo)
    {
        $this->lastFmAlbumInfo = $lastFmAlbumInfo;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastFmInfoQuery()
    {
        return ['album' => $this->album->getName(), 'artist' => $this->album->getArtist()->getName()];
    }

    /**
     * {@inheritdoc}
     */
    public function getMusicBrainzId()
    {
        return $this->album->getMusicBrainzId();
    }

    /**
     * {@inheritdoc}
     */
    public function setMusicBrainzId($musicBrainzId)
    {
        $this->album->setMusicBrainzId($musicBrainzId);
    }

    /**
     * {@inheritdoc}
     */
    public function updateLastFmInfo(AlbumInterface $album)
    {
        if ($album !== $this->album) {
            unset($this->album);
            $this->album = $album;
            $lastFmInfo = $this->lastFmAlbumInfo->getInfo($this);
            if ($lastFmInfo !== null) {
                $album->setCover($lastFmInfo['image']['large']);
                $album->setLastFmId($lastFmInfo['id']);
                $album->setLastFmUrl($lastFmInfo['url']);
                $album->setReleaseDate(new DateTime($lastFmInfo['releasedate']));
            }
            unset($lastFmInfo);
        }
    }
}
