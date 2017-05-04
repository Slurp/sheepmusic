<?php

namespace BlackSheep\MusicLibraryBundle\Model;

/**
 * Interface SongInterface
 *
 * @package BlackSheep\MusicLibraryBundle\Model
 */
interface SongInterface extends ApiInterface, PlayCountInterface
{
    /**
     * @param $songInfo
     *
     * @return SongInterface
     */
    public static function createFromArray($songInfo);

    /**
     * @return string
     */
    public function getTrack();

    /**
     * @param mixed $track
     *
     * @return SongInterface
     */
    public function setTrack($track);

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param mixed $title
     *
     * @return SongInterface
     */
    public function setTitle($title);

    /**
     * @return integer
     */
    public function getLength();

    /**
     * @param mixed $length
     *
     * @return SongInterface
     */
    public function setLength($length);

    /**
     * @return integer
     */
    public function getMTime();

    /**
     * @param mixed $mTime
     *
     * @return SongInterface
     */
    public function setMTime($mTime);

    /**
     * @return string
     */
    public function getPath();

    /**
     * @param mixed $path
     *
     * @return SongInterface
     */
    public function setPath($path);

    /**
     * @return AlbumInterface
     */
    public function getAlbum();

    /**
     * @param AlbumInterface $album
     *
     * @return SongInterface
     */
    public function setAlbum(AlbumInterface $album = null);

    /**
     * @return PlaylistInterface[]
     */
    public function getPlaylists();

    /**
     * @param PlaylistInterface[] $playlists
     *
     * @return SongInterface
     */
    public function setPlaylists($playlists);

    /**
     * @param PlaylistInterface $playlist
     *
     * @return SongInterface
     */
    public function addPlaylist(PlaylistInterface $playlist);

    /**
     * @param PlaylistInterface $playlist
     *
     * @return SongInterface
     */
    public function removePlaylist(PlaylistInterface $playlist);


    /**
     * @return ArtistInterface
     */
    public function getArtist();

    /**
     * @return ArtistInterface[]
     */
    public function getArtists();

    /**
     * @param ArtistInterface[] $artists
     *
     * @return SongInterface
     */
    public function setArtists($artists);

    /**
     * @param ArtistInterface $artist
     *
     * @return SongInterface
     */
    public function addArtist(ArtistInterface $artist);
}
