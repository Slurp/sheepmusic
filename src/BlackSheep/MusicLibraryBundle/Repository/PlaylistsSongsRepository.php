<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibraryBundle\Repository;

use BlackSheep\MusicLibraryBundle\Model\SongInterface;

/**
 * Class PlaylistsSongsRepository.
 */
class PlaylistsSongsRepository extends AbstractRepository implements PlaylistsSongsRepositoryInterface
{
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
