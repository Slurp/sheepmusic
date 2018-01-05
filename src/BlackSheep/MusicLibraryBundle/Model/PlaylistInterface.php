<?php

namespace BlackSheep\MusicLibraryBundle\Model;

interface PlaylistInterface
{
    /**
     * @param string|null $name
     *
     * @return PlaylistInterface
     */
    public static function create($name = null);

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

    /**
     * @return PlaylistsSongsInterface[]
     */
    public function getSongs();

    /**
     * @param PlaylistsSongsInterface[] $songs
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
