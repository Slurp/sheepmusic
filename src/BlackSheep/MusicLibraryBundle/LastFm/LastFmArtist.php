<?php
namespace BlackSheep\MusicLibraryBundle\LastFm;

use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;

/**
 *
 */
class LastFmArtist implements LastFmArtistInterface
{
    /**
     * @var LastFmArtistInfo
     */
    protected $lastFmArtistInfo;

    /**
     * @var ArtistInterface
     */
    protected $artist;

    /**
     * @param LastFmArtistInfo $lastFmArtistInfo
     */
    public function __construct(LastFmArtistInfo $lastFmArtistInfo)
    {
        $this->lastFmArtistInfo = $lastFmArtistInfo;
    }

    /**
     * @inheritDoc
     */
    public function getLastFmInfoQuery()
    {
        return ['artist' => $this->artist->getName()];
    }

    /**
     * @inheritDoc
     */
    public function getMusicBrainzId()
    {
        return $this->artist->getMusicBrainzId();
    }

    /**
     * @inheritDoc
     */
    public function setMusicBrainzId($musicBrainzId)
    {
        $this->artist->setMusicBrainzId($musicBrainzId);
    }

    /**
     * @inheritdoc
     */
    public function updateLastFmInfo(ArtistInterface $artist)
    {
        if ($artist !== $this->artist) {
            $this->artist = $artist;
            $lastFmInfo = $this->lastFmArtistInfo->getInfo($this);
            if ($lastFmInfo !== null) {
                $artist->setImage($lastFmInfo['image']['large']);
                $artist->setBiography($lastFmInfo['bio']['summary']);
            }
        }
    }
}