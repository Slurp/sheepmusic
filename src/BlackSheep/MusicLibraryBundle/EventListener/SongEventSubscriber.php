<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibraryBundle\EventListener;

use BlackSheep\MusicLibraryBundle\Events\SongEventInterface;
use BlackSheep\MusicLibraryBundle\Model\PlayCountInterface;
use BlackSheep\MusicLibraryBundle\Repository\SongsRepositoryInterface;

/**
 * SongEventSubscriber.
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
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return [
            SongEventInterface::SONG_EVENT_PLAYED => 'playedSong',
        ];
    }

    /**
     * @param SongEventInterface $songEvent
     */
    public function playedSong(SongEventInterface $songEvent)
    {
        $song = $songEvent->getSong();
        if ($song instanceof PlayCountInterface) {
            $this->songsRepository->save($song->updatePlayCount());
        }
        if ($song->getAlbum() instanceof PlayCountInterface) {
            $this->songsRepository->save($song->getAlbum()->updatePlayCount());
        }
        if ($song->getGenre() instanceof PlayCountInterface) {
            $this->songsRepository->save($song->getGenre()->updatePlayCount());
        }
        if ($song->getArtist() instanceof PlayCountInterface) {
            $this->songsRepository->save($song->getArtist()->updatePlayCount());
        }
    }
}
