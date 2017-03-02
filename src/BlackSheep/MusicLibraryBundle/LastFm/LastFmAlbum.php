<?php
namespace BlackSheep\MusicLibraryBundle\LastFm;

use BlackSheep\MusicLibraryBundle\Model\AlbumInterface;
use DateTime;

/**
 *
 */
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
     * @inheritDoc
     */
    public function getLastFmInfoQuery()
    {
        return ['album' => $this->album->getName(), 'artist' => $this->album->getArtist()->getName()];
    }

    /**
     * @inheritDoc
     */
    public function getMusicBrainzId()
    {
        return $this->album->getMusicBrainzId();
    }

    /**
     * @inheritDoc
     */
    public function setMusicBrainzId($musicBrainzId)
    {
        $this->album->setMusicBrainzId($musicBrainzId);
    }

    /**
     * @inheritdoc
     */
    public function updateLastFmInfo(AlbumInterface $album)
    {
        if ($album !== $this->album) {
            $this->album = $album;
            $lastFmInfo = $this->lastFmAlbumInfo->getInfo($this);
            if ($lastFmInfo !== null) {
                $album->setLastFmId($lastFmInfo['lastfmid']);
                $album->setLastFmUrl($lastFmInfo['url']);
                $album->setReleaseDate(new DateTime($lastFmInfo['releasedate']));
            }
        }
    }
}