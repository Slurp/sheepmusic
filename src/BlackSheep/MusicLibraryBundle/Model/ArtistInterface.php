<?php

namespace BlackSheep\MusicLibraryBundle\Model;

use BlackSheep\MusicLibraryBundle\MusicBrainz\MusicBrainzModelInterface;

/**
 * Interface AlbumInterface
 */
interface ArtistInterface extends ApiInterface, MusicBrainzModelInterface
{

    /**
     * @param      $name
     * @param null $musicBrainzId
     * @return ArtistInterface
     */
    public static function createNew($name, $musicBrainzId = null);

    /**
     * @return mixed
     */
    public function getSlug();

    /**
     * @return mixed
     */
    public function getAlias();

    /**
     * @return mixed
     */
    public function getName();

    /**
     * @param mixed $name
     * @return ArtistInterface
     */
    public function setName($name);

    /**
     * @return mixed
     */
    public function getImage();

    /**
     * @param mixed $image
     * @return ArtistInterface
     */
    public function setImage($image);

    /**
     * @return mixed
     */
    public function getBiography();

    /**
     * @param mixed $biography
     * @return ArtistInterface
     */
    public function setBiography($biography);

    /**
     * @return AlbumInterface[]
     */
    public function getAlbums();

    /**
     * @param mixed $albums
     * @return ArtistInterface
     */
    public function setAlbums($albums);

    /**
     * @return mixed
     */
    public function getSongs();

    /**
     * @param mixed $songs
     * @return ArtistInterface
     */
    public function setSongs($songs);

    /**
     * @param SongInterface $song
     * @return AlbumInterface
     */
    public function addSong(SongInterface $song);

    /**
     * @return mixed
     */
    public function getPlayCount();

    /**
     * @param mixed $playCount
     * @return ArtistInterface
     */
    public function setPlayCount($playCount);

    /**
     * @return mixed
     */
    public function getAlbumArt();
}
