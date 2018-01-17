<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
                if ($artist->getName() !== (string) $lastFmInfo->artist->name) {
                    $artist->setName((string) $lastFmInfo->artist->name);
                }
                if (empty($artist->getImage())) {
                    $artist->setImage((string) $lastFmInfo->artist->image[2]);
                }
                $artist->setBiography((string) $lastFmInfo->artist->bio->content);
            }
            unset($lastFmInfo);
        }
    }
}
