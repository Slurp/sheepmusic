<?php

namespace BlackSheep\MusicLibraryBundle\EventListener;

use BlackSheep\MusicLibraryBundle\Events\SongEventInterface;
use BlackSheep\MusicLibraryBundle\Repository\SongsRepositoryInterface;

class SongEventSubscriber implements SongEventListener
{
    /**
     * @var SongsRepositoryInterface
     */
    protected $songsRepository;

    public function __construct(SongsRepositoryInterface $songsRepository)
    {
        $this->songsRepository = $songsRepository;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return [
            SongEventInterface::SONG_EVENT_PLAYED => 'playedSong',
            SongEventInterface::SONG_EVENT_LOVED => 'lovedSong',
            SongEventInterface::SONG_EVENT_RATED => 'ratedSong',
            ];
    }

    /**
     * {@inheritdoc}
     */
    public function playedSong(SongEventInterface $songEvent)
    {
        $song = $songEvent->getSong();
        $playCount = $song->getPlayCount() + 1;
        $song->setPlayCount($playCount);
        $this->songsRepository->save($song);
    }

    /**
     * {@inheritdoc}
     */
    public function lovedSong(SongEventInterface $songEvent)
    {
        // TODO: Implement playedSong() method.
    }

    /**
     * {@inheritdoc}
     */
    public function ratedSong(SongEventInterface $songEvent)
    {
        // TODO: Implement playedSong() method.
    }
}
