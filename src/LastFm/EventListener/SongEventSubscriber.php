<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\LastFm\EventListener;

use BlackSheep\LastFm\Info\LastFmTrackInfo;
use BlackSheep\MusicLibrary\EventListener\SongEventListener;
use BlackSheep\MusicLibrary\Events\SongEventInterface;

class SongEventSubscriber implements SongEventListener
{
    /**
     * @var LastFmTrackInfo
     */
    protected $lastFmTrackInfo;

    /**
     * SongEventSubscriber constructor.
     *
     * @param LastFmTrackInfo $lastFmTrackInfo
     */
    public function __construct(LastFmTrackInfo $lastFmTrackInfo)
    {
        $this->lastFmTrackInfo = $lastFmTrackInfo;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return [
            SongEventInterface::SONG_EVENT_PLAYING => 'playingSong',
            SongEventInterface::SONG_EVENT_PLAYED => 'playedSong',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function playingSong(SongEventInterface $songEvent)
    {
        $this->lastFmTrackInfo->nowPlayingTrack($songEvent->getSong());
    }

    /**
     * {@inheritdoc}
     */
    public function playedSong(SongEventInterface $songEvent)
    {
        try {
            $this->lastFmTrackInfo->scrobbleTrack($songEvent->getSong());
        } catch (\Exception $e) {
            // do nothing for now
            error_log($e->getMessage());
        }
    }
}
