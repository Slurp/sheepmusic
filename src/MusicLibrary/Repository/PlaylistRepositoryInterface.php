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

use BlackSheep\MusicLibrary\Model\PlaylistInterface;
use BlackSheep\MusicLibrary\Model\SongInterface;
use BlackSheep\User\Model\UserInterface;

/**
 * Interface AlbumsRepositoryInterface.
 */
interface PlaylistRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param string $name
     *
     * @return PlaylistInterface
     */
    public function getByName($name);

    /**
     * @param $name
     * @param SongInterface[] $songs
     * @param UserInterface $user
     *
     * @return PlaylistInterface|bool
     */
    public function savePlaylistWithSongs($name, $songs, UserInterface $user = null);
}
