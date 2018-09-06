<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\LastFm\Info;

use BlackSheep\MusicLibrary\Model\SongInterface;
use DateTime;
use DateTimeZone;
use LastFmApi\Api\TrackApi;
use LastFmApi\Exception\InvalidArgumentException;
use LastFmApi\Exception\NotAuthenticatedException;

/**
 * Api wrapper for BlackSheep.
 */
class LastFmTrackInfo extends AbstractLastFmInfo implements LastFmInfo
{
    /**
     * @throws InvalidArgumentException
     *
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
        try {
            if ($this->isUserAuth) {
                $this->getApi()->updateNowPlaying($this->getMethodVars($song));
            }
        } catch (InvalidArgumentException $connectionException) {
        } catch (NotAuthenticatedException $apiFailedException) {
        }
    }

    /**
     * Only scrobble when a userAuth is available.
     *
     * @param SongInterface $song
     */
    public function scrobbleTrack(SongInterface $song)
    {
        try {
            if ($this->isUserAuth) {
                $this->getApi()->scrobble($this->getMethodVars($song));
            }
        } catch (InvalidArgumentException $connectionException) {
        } catch (NotAuthenticatedException $apiFailedException) {
        }
    }

    /**
     * @param SongInterface $song
     *
     * @return array
     */
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
