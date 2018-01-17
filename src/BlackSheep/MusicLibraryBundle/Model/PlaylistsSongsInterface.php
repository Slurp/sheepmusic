<?php
/**
 * Created by PhpStorm.
 * User: slangeweg
 * Date: 30/12/2017
 * Time: 00:35.
 */

namespace BlackSheep\MusicLibraryBundle\Model;

interface PlaylistsSongsInterface
{
    /**
     * @return integer
     */
    public function getPosition();

    /**
     * @param integer $position
     *
     * @return PlaylistsSongs
     */
    public function setPosition($position);

    /**
     * @return PlaylistInterface
     */
    public function getPlaylist();

    /**
     * @param PlaylistInterface $playlist
     * @return void
     */
    public function setPlaylist(PlaylistInterface $playlist);

    /**
     * @return SongInterface
     */
    public function getSong();

    /**
     * @param SongInterface $song
     * @return void
     */
    public function setSong(SongInterface $song);
}
