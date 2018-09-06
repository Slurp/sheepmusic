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

use BlackSheep\MusicLibrary\Events\AlbumEvent;
use BlackSheep\MusicLibrary\Repository\AlbumsRepository;
use BlackSheep\MusicLibrary\Repository\PlaylistRepository;
use BlackSheep\MusicLibrary\Repository\PlaylistsSongsRepository;
use BlackSheep\MusicLibrary\Repository\SongsRepository;

/**
 * AlbumEventSubscriber.
 */
class AlbumEventSubscriber implements AlbumEventListener
{
    /**
     * @var SongsRepository
     */
    protected $songsRepository;

    /**
     * @var AlbumsRepository
     */
    protected $albumsRepository;

    /**
     * @var PlaylistRepository
     */
    protected $playlistRepository;

    /**
     * @var PlaylistsSongsRepository
     */
    protected $playlistsSongsRepo;

    /**
     * @param AlbumsRepository $albumsRepository
     * @param PlaylistRepository $playlistRepository
     * @param PlaylistsSongsRepository $playlistsSongsRepo
     * @param SongsRepository $songsRepository
     */
    public function __construct(
        AlbumsRepository $albumsRepository,
        PlaylistRepository $playlistRepository,
        PlaylistsSongsRepository $playlistsSongsRepo,
        SongsRepository $songsRepository
    ) {
        $this->albumsRepository = $albumsRepository;
        $this->playlistRepository = $playlistRepository;
        $this->playlistsSongsRepo = $playlistsSongsRepo;
        $this->songsRepository = $songsRepository;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return [
            AlbumEvent::ALBUM_EVENT_VALIDATE_SONGS => 'checkSongs',
        ];
    }

    /**
     * @param AlbumEvent $event
     */
    public function checkSongs(AlbumEvent $event)
    {
        $album = $event->getAlbum();
        $artist = $album->getArtist();
        foreach ($album->getSongs() as $song) {
            if (file_exists($song->getPath()) === false) {
                $album->removeSong($song);
                $artist->removeSong($song);
                $this->playlistsSongsRepo->removeSongFromPlaylists($song);
                $this->songsRepository->remove($song);
            }
        }
        if (count($album->getSongs()) === 0) {
            $this->albumsRepository->remove($album);
        } else {
            $this->albumsRepository->save($album);
            $this->albumsRepository->save($artist);
        }
    }
}
