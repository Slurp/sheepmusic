<?php
/**
 * @author: @{USER} <stephan@bureaublauwgeel.nl>
 * Date: 17/04/17
 * Time: 17:15
 * @copyright 2017 Bureau Blauwgeel
 * @version 1.0
 */

namespace BlackSheep\MusicLibraryBundle\Model;

/**
 *
 */
interface PlaylistInterface
{
    /**
     * @return mixed
     */
    public function getName();

    /**
     * @param mixed $name
     *
     * @return $this
     */
    public function setName($name);

    /**
     * @return SongInterface[]
     */
    public function getSongs();

    /**
     * @param mixed $songs
     *
     * @return $this
     */
    public function setSongs($songs);

    /**
     * @param SongInterface $song
     *
     * @return $this
     */
    public function addSong(SongInterface $song);

    /**
     * @param SongInterface $song
     *
     * @return $this
     */
    public function removeSong(SongInterface $song);

    /**
     * @return AlbumInterface[]
     */
    public function getAlbums();

    /**
     * @return string
     */
    public function getCover();

    /**
     * @param string $cover
     *
     * @return PlaylistInterface
     */
    public function setCover($cover);
}