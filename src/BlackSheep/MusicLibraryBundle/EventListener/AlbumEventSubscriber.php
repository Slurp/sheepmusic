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

use BlackSheep\MusicLibraryBundle\Events\AlbumEventInterface;
use BlackSheep\MusicLibraryBundle\Repository\AlbumsRepositoryInterface;
use BlackSheep\MusicLibraryBundle\Repository\PlaylistRepositoryInterface;
use BlackSheep\MusicLibraryBundle\Repository\PlaylistsSongsRepository;
use BlackSheep\MusicLibraryBundle\Repository\PlaylistsSongsRepositoryInterface;
use BlackSheep\MusicLibraryBundle\Repository\SongsRepository;

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
     * @var AlbumsRepositoryInterface
     */
    protected $albumsRepository;

    /**
     * @var PlaylistRepositoryInterface
     */
    protected $playlistRepository;

    /**
     * @var PlaylistsSongsRepositoryInterface
     */
    protected $playlistsSongsRepository;

    /**
     * @param AlbumsRepositoryInterface   $albumsRepository
     * @param PlaylistRepositoryInterface $playlistRepository
     * @param PlaylistsSongsRepository    $playlistsSongsRepository
     * @param SongsRepository             $songsRepository
     */
    public function __construct(
        AlbumsRepositoryInterface $albumsRepository,
        PlaylistRepositoryInterface $playlistRepository,
        PlaylistsSongsRepository $playlistsSongsRepository,
        SongsRepository $songsRepository
    ) {
        $this->albumsRepository = $albumsRepository;
        $this->playlistRepository = $playlistRepository;
        $this->playlistsSongsRepository = $playlistsSongsRepository;
        $this->songsRepository = $songsRepository;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return [
            AlbumEventInterface::ALBUM_EVENT_VALIDATE_SONGS => 'checkSongs',
        ];
    }

    /**
     * @param AlbumEventInterface $event
     */
    public function checkSongs(AlbumEventInterface $event)
    {
        $album = $event->getAlbum();
        $artist = $album->getArtist();
        foreach ($album->getSongs() as $song) {
            if (file_exists($song->getPath()) === false) {
                $album->removeSong($song);
                $artist->removeSong($song);
                $this->playlistsSongsRepository->removeSongFromPlaylists($song);
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
