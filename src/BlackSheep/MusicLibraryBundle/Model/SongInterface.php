<?php
namespace BlackSheep\MusicLibraryBundle\Model;

/**
 * SongInterface = SING
 */
interface SongInterface extends ApiInterface
{
    
    /**
     * @param $songInfo
     * @return SongInterface
     */
    public static function createFromArray($songInfo);

    /**
     * @return mixed
     */
    public function getTrack();

    /**
     * @param mixed $track
     * @return SongInterface
     */
    public function setTrack($track);

    /**
     * @return mixed
     */
    public function getTitle();
    /**
     * @param mixed $title
     * @return SongInterface
     */
    public function setTitle($title);

    /**
     * @return mixed
     */
    public function getLength();

    /**
     * @param mixed $length
     * @return SongInterface
     */
    public function setLength($length);

    /**
     * @return mixed
     */
    public function getMTime();

    /**
     * @param mixed $mTime
     * @return SongInterface
     */
    public function setMTime($mTime);

    /**
     * @return mixed
     */
    public function getPath();

    /**
     * @param mixed $path
     * @return SongInterface
     */
    public function setPath($path);

    /**
     * @return AlbumInterface
     */
    public function getAlbum();

    /**
     * @param AlbumInterface $album
     * @return SongInterface
     */
    public function setAlbum(AlbumInterface $album = null);

    /**
     * @return mixed
     */
    public function getPlayCount();

    /**
     * @param mixed $playCount
     * @return SongInterface
     */
    public function setPlayCount($playCount);

    /**
     * @return mixed
     */
    public function getPlaylist();

    /**
     * @param mixed $playlist
     * @return SongInterface
     */
    public function setPlaylist($playlist);

    /**
     * @return ArtistInterface
     */
    public function getArtist();

    /**
     * @return ArtistInterface[]
     */
    public function getArtists();

    /**
     * @param mixed $artists
     * @return SongInterface
     */
    public function setArtists($artists);

    /**
     * @param ArtistInterface $artist
     * @return SongInterface
     */
    public function addArtist(ArtistInterface $artist);
}
