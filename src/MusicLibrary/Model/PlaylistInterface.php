<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Model;

use BlackSheep\User\Model\SheepUser;
use Doctrine\Common\Collections\ArrayCollection;

interface PlaylistInterface
{
    /**
     * @param string|null $name
     *
     * @return PlaylistInterface
     */
    public static function create($name = null);

    /**
     * @return SheepUser
     */
    public function getUser(): SheepUser;

    /**
     * @param SheepUser $user
     */
    public function setUser(SheepUser $user = null): void;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param mixed $name
     *
     * @return $this
     */
    public function setName(string $name);

    /**
     * @return AlbumInterface[]
     */
    public function getAlbums();

    /**
     * @return string
     */
    public function getCover(): string;

    /**
     * @param string $cover
     *
     * @return PlaylistInterface
     */
    public function setCover(string $cover);

    /**
     * @return PlaylistsSongsInterface[]
     */
    public function getSongs();

    /**
     * @param PlaylistsSongsInterface[]|ArrayCollection $songs
     *
     * @return array
     */
    public function setSongs($songs);

    /**
     * @param PlaylistsSongsInterface $song
     *
     * @return $this
     */
    public function addSong(PlaylistsSongsInterface $song);

    /**
     * @param PlaylistsSongsInterface $song
     *
     * @return $this
     */
    public function removeSong(PlaylistsSongsInterface $song);
}
