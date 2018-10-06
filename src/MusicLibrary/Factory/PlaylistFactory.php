<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Factory;

use BlackSheep\MusicLibrary\Model\PlaylistInterface;
use BlackSheep\MusicLibrary\Repository\AlbumsRepository;
use BlackSheep\MusicLibrary\Repository\PlaylistRepository;
use BlackSheep\MusicLibrary\Repository\SongsRepository;

/**
 * Class ArtworkFactory.
 */
class PlaylistFactory
{
    /**
     * @var PlaylistRepository
     */
    protected $playlistRepository;

    /**
     * @var AlbumsRepository
     */
    protected $albumsRepository;

    /**
     * @var SongsRepository
     */
    protected $songsRepository;

    /**
     * @param PlaylistRepository $playlistRepository
     * @param AlbumsRepository $albumsRepository
     */
    public function __construct(
        PlaylistRepository $playlistRepository,
        AlbumsRepository $albumsRepository,
        SongsRepository $songsRepository
    ) {
        $this->playlistRepository = $playlistRepository;
        $this->albumsRepository = $albumsRepository;
        $this->songsRepository = $songsRepository;
    }

    /**
     * @return PlaylistInterface|bool
     */
    public function createLastImportedPlaylist()
    {
        $albums = $this->albumsRepository->getLatestAlbums();
        $songs = [];
        foreach ($albums as $album) {
            $songs = array_merge($album->getSongs()->toArray(), $songs);
        }
        $playlist = $this->playlistRepository->savePlaylistWithSongs('last imported', $songs);

        return $playlist;
    }

    /**
     * @return PlaylistInterface|bool
     */
    public function createMostPlayedPlaylist()
    {
        return $this->playlistRepository->savePlaylistWithSongs(
            'Most Played',
            $this->songsRepository->getMostPlayed()
        );
    }
}
