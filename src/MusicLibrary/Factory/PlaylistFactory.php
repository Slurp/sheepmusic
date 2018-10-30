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

use BlackSheep\MusicLibrary\Entity\SimilarArtist\SimilarArtistEntity;
use BlackSheep\MusicLibrary\Model\ArtistInterface;
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

    /**
     * @return PlaylistInterface|bool
     */
    public function createLastPlayedPlaylist()
    {
        return $this->playlistRepository->savePlaylistWithSongs(
            'Last Played',
            $this->songsRepository->getLastPlayed()
        );
    }

    /**
     * @param ArtistInterface $artist
     *
     * @return PlaylistInterface|bool
     */
    public function createSmartPlaylistForArtist(ArtistInterface $artist)
    {
        $artistSongs = [];
        $usedArtists = [$artist->getSlug()];
        $this->randomSongsForArtist($artist, $artistSongs);

        return $this->playlistRepository->savePlaylistWithSongs(
            'Based on ' . $artist->getName(),
            $this->getSongsFromSimilarArtist(
                $artist,
                $usedArtists,
                $artistSongs
            )
        );
    }

    /**
     * @param ArtistInterface $artist
     * @param array $usedArtists
     * @param array $songList
     * @param int $level
     *
     * @return array|null
     */
    protected function getSongsFromSimilarArtist(
        ArtistInterface $artist,
        array &$usedArtists,
        array &$songList,
        int $level = 0
    ): ?array {
        if ($level < 3) {
            /** @var SimilarArtistEntity $similarArtist */
            foreach ($artist->getSimilarArtists()->slice(0,3) as $similarArtist) {
                if (in_array($similarArtist->getSimilar()->getSlug(), $usedArtists) === false) {
                    $usedArtists[] = $similarArtist->getSimilar()->getSlug();
                    $this->randomSongsForArtist($similarArtist->getSimilar(), $songList);
                    $this->getSongsFromSimilarArtist(
                        $similarArtist->getSimilar(),
                        $usedArtists,
                        $songList,
                        ++$level);
                }
            }
        }
        return $songList;
    }

    /**
     * @param $songList
     * @param ArtistInterface $artist
     * @param int $amount
     */
    protected function randomSongsForArtist(ArtistInterface $artist, &$songList, $amount = 3)
    {
        $artistsSongs = $artist->getSongs()->toArray();
        foreach (array_rand($artistsSongs, $amount) as $songIndex) {
            $songList[] = $artistsSongs[$songIndex];
        }
    }
}
