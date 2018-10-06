<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\EventListener;

use BlackSheep\MusicLibrary\Events\SongEventInterface;
use BlackSheep\MusicLibrary\Model\PlayCountInterface;
use BlackSheep\MusicLibrary\Repository\SongsRepositoryInterface;

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
            $song->updatePlayCount();
        }
        if ($song->getAlbum() instanceof PlayCountInterface) {
            $song->getAlbum()->updatePlayCount();
        }
        if ($song->getGenre() instanceof PlayCountInterface) {
            $song->getGenre()->updatePlayCount();
        }
        if ($song->getArtist() instanceof PlayCountInterface) {
            $song->getArtist()->updatePlayCount();
        }
        $this->songsRepository->save($song);
        $this->songsRepository->save($song->getArtist());
        $this->songsRepository->save($song->getGenre());
        $this->songsRepository->save($song->getAlbum());
    }
}
