<?php

namespace BlackSheep\MusicLibraryBundle\LastFm;

use BlackSheep\LastFmBundle\Info\LastFmArtistInfo;
use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;

/**
 * Enrich the artist with his lastFm info.
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
     * {@inheritdoc}
     */
    public function getLastFmInfoQuery()
    {
        if (empty($this->artist->getMusicBrainzId()) === false) {
            return ['mbid' => $this->artist->getMusicBrainzId(), 'autocorrect' => '1'];
        }

        return ['artist' => $this->artist->getName(), 'autocorrect' => '1'];
    }

    /**
     * {@inheritdoc}
     */
    public function getMusicBrainzId()
    {
        return $this->artist->getMusicBrainzId();
    }

    /**
     * {@inheritdoc}
     */
    public function setMusicBrainzId($musicBrainzId)
    {
        $this->artist->setMusicBrainzId($musicBrainzId);
    }

    /**
     * {@inheritdoc}
     */
    public function updateLastFmInfo(ArtistInterface $artist)
    {
        if ($artist !== $this->artist) {
            unset($this->artist);
            $this->artist = $artist;
            $lastFmInfo = $this->lastFmArtistInfo->getInfo($this);
            if ($lastFmInfo !== null) {
                if ($artist->getName() !== $lastFmInfo['name']) {
                    $artist->setName($lastFmInfo['name']);
                }
                if (empty($artist->getImage())) {
                    $artist->setImage($lastFmInfo['image']['large']);
                }
                $artist->setBiography($lastFmInfo['bio']['summary']);
            }
            unset($lastFmInfo);
        }
    }
}
