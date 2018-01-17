<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\LastFmBundle\Info;

use BlackSheep\MusicLibraryBundle\Model\SongInterface;
use DateTime;
use DateTimeZone;
use LastFmApi\Api\TrackApi;

/**
 * Api wrapper for BlackSheep.
 */
class LastFmTrackInfo extends AbstractLastFmInfo implements LastFmInfo
{
    /**
     * @return TrackApi
     */
    protected function getApi()
    {
        if ($this->api === null) {
            $this->api = new TrackApi($this->getAuth());
        }

        return $this->api;
    }

    /**
     * @param SongInterface $song
     */
    public function nowPlayingTrack(SongInterface $song)
    {
        $this->getApi()->updateNowPlaying($this->getMethodVars($song));
    }

    /**
     * @param SongInterface $song
     */
    public function scrobbleTrack(SongInterface $song)
    {
        $this->getApi()->scrobble($this->getMethodVars($song));
    }

    protected function getMethodVars(SongInterface $song)
    {
        $now = new DateTime('now', new DateTimeZone('UTC'));

        return [
            'artist' => $song->getArtist()->getName(),
            'trackNumber' => $song->getTrack(),
            'track' => $song->getTitle(),
            'timestamp' => $now->getTimestamp(),
            'album' => $song->getAlbum()->getName(),
        ];
    }
}
