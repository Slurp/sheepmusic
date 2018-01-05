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
    public function getPosition();

    public function setPosition($position);

    /**
     * @return PlaylistInterface
     */
    public function getPlaylist();

    /**
     * @param PlaylistInterface $playlist
     */
    public function setPlaylist(PlaylistInterface $playlist);

    /**
     * @return SongInterface
     */
    public function getSong();

    /**
     * @param SongInterface $song
     */
    public function setSong(SongInterface $song);
}
