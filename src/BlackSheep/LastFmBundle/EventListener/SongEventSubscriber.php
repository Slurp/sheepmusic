<?php
namespace BlackSheep\LastFmBundle\EventListener;

use BlackSheep\LastFmBundle\Info\LastFmTrackInfo;
use BlackSheep\MusicLibraryBundle\EventListener\SongEventListener;
use BlackSheep\MusicLibraryBundle\Events\SongEventInterface;

class SongEventSubscriber implements SongEventListener
{
    /**
     * @var LastFmTrackInfo
     */
    protected $lastFmTrackInfo;

    public function __construct(LastFmTrackInfo $lastFmTrackInfo)
    {

        $this->lastFmTrackInfo = $lastFmTrackInfo;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return [
            SongEventInterface::SONG_EVENT_PLAYING => "playingSong",
            SongEventInterface::SONG_EVENT_PLAYED => "playedSong",
            SongEventInterface::SONG_EVENT_LOVED => "lovedSong",
            SongEventInterface::SONG_EVENT_RATED => "ratedSong"
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function playingSong(SongEventInterface $songEvent)
    {
        $this->lastFmTrackInfo->nowPlayingTrack($songEvent->getSong());
    }

    /**
     * {@inheritDoc}
     */
    public function playedSong(SongEventInterface $songEvent)
    {
        $this->lastFmTrackInfo->scrobbleTrack($songEvent->getSong());
    }

    /**
     * {@inheritDoc}
     */
    public function lovedSong(SongEventInterface $songEvent)
    {
        // TODO: Implement playedSong() method.
    }

    /**
     * {@inheritDoc}
     */
    public function ratedSong(SongEventInterface $songEvent)
    {
        // TODO: Implement playedSong() method.
    }
}
