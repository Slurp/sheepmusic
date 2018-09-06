<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Repository;

use BlackSheep\MusicLibrary\Entity\PlaylistsSongsEntity;
use BlackSheep\MusicLibrary\Model\SongInterface;

/**
 * Class PlaylistsSongsRepository.
 */
class PlaylistsSongsRepository extends AbstractRepository implements PlaylistsSongsRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    protected static function getEntityClass(): string
    {
        return PlaylistsSongsEntity::class;
    }

    /**
     * {@inheritdoc}
     */
    public function findPlaylistsForSong(SongInterface $song)
    {
        return $this->findBy(['song' => $song]);
    }

    public function removeSongFromPlaylists(SongInterface $song)
    {
        $playlistsSongs = $this->findPlaylistsForSong($song);
        if ($playlistsSongs !== null) {
            foreach ($playlistsSongs as $playlistSong) {
                $playlist = $playlistSong->getPlaylist();
                $playlist->removeSong($playlistSong);
                $this->save($playlist);
                unset($playlist);
            }
            unset($playlistsSongs);
        }
    }
}
