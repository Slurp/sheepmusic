<?php
namespace BlackSheep\MusicLibraryBundle\EventListener;

use BlackSheep\MusicLibraryBundle\Events\SongEventInterface;
use BlackSheep\MusicLibraryBundle\Repository\SongsRepositoryInterface;

/**
 * SongEventSubscriber
 */
class SongEventSubscriber implements SongEventListener
{
    /**
     * @var SongsRepositoryInterface
     */
    protected $songsRepository;

    /**
     * @param SongsRepositoryInterface $songsRepository
     */
    public function __construct(SongsRepositoryInterface $songsRepository)
    {
        $this->songsRepository = $songsRepository;
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

    }

    /**
     * {@inheritDoc}
     */
    public function playedSong(SongEventInterface $songEvent)
    {
        $song = $songEvent->getSong();
        $playCount = $song->getPlayCount() + 1;
        $song->setPlayCount($playCount);
        $this->songsRepository->save($song);
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
