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

use BlackSheep\LastFmBundle\Info\LastFmAlbumInfo;
use BlackSheep\MusicLibraryBundle\Model\AlbumInterface;
use DateTime;

/**
 * Class LastFmAlbum.
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
     * {@inheritdoc}
     */
    public function getLastFmInfoQuery()
    {
        if ($this->getMusicBrainzId() !== null) {
            return ['mbid' => $this->getMusicBrainzId(), 'autocorrect' => '1'];
        }

        return [
            'album' => $this->album->getName(),
            'artist' => $this->album->getArtist()->getName(),
            'autocorrect' => '1',
        ];
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
            if ($lastFmInfo !== null && $lastFmInfo->album !== null) {
                $album->setName((string) $lastFmInfo->album->name);
                $album->setLastFmId((string) $lastFmInfo->album->id);
                $album->setLastFmUrl($lastFmInfo->album->url);
                if (empty($album->getCover())) {
                    $album->setCover((string) $lastFmInfo->album->image[2]);
                }
                if (empty($lastFmInfo->album->releasedate->__toString()) === false) {
                    $album->setReleaseDate(new DateTime((string) $lastFmInfo->album->releasedate));
                }
            }
            unset($lastFmInfo);
        }
    }
}
