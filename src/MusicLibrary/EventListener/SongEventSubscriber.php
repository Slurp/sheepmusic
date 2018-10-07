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
use BlackSheep\MusicLibrary\Factory\PlaylistFactory;
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
     * @var PlaylistFactory
     */
    protected $playlistFactory;

    /**
     * @param SongsRepositoryInterface $songsRepository
     * @param PlaylistFactory $playlistFactory
     */
    public function __construct(SongsRepositoryInterface $songsRepository, PlaylistFactory $playlistFactory)
    {
        $this->songsRepository = $songsRepository;
        $this->playlistFactory = $playlistFactory;
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
        $song->setLastPlayedDate(new \DateTime());
        if ($song instanceof PlayCountInterface) {
            $song->updatePlayCount();
        }
        if ($song->getAlbum() instanceof PlayCountInterface) {
            $song->getAlbum()->updatePlayCount();
            $this->songsRepository->save($song->getAlbum());
        }
        if ($song->getGenre() instanceof PlayCountInterface) {
            $song->getGenre()->updatePlayCount();
            $this->songsRepository->save($song->getGenre());
        }
        if ($song->getArtist() instanceof PlayCountInterface) {
            $song->getArtist()->updatePlayCount();
            $this->songsRepository->save($song->getArtist());
        }
        $this->songsRepository->save($song);
        $this->playlistFactory->createMostPlayedPlaylist();
    }
}
