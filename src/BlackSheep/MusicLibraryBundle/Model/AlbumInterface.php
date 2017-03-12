<?php

namespace BlackSheep\MusicLibraryBundle\Model;

/**
 * Interface AlbumInterface.
 */
interface AlbumInterface extends ApiInterface
{
    /**
     * @param $name
     * @param $artist
     * @param $extraInfo
     *
     * @return AlbumInterface
     */
    public static function createArtistAlbum($name, $artist, $extraInfo);

    /**
     * @return mixed
     */
    public function getSlug();

    /**
     * @return mixed
     */
    public function getName();

    /**
     * @param mixed $name
     *
     * @return AlbumInterface
     */
    public function setName($name);

    /**
     * @return mixed
     */
    public function getCover();

    /**
     * @param mixed $cover
     *
     * @return AlbumInterface
     */
    public function setCover($cover);

    /**
     * Generate a cover from provided data.
     *
     * @param array $cover The cover data in array format, extracted by getID3.
     *                     For example:
     *                     [
     *                     'data' => '<binary data>',
     *                     'image_mime' => 'image/png',
     *                     'image_width' => 512,
     *                     'image_height' => 512,
     *                     'imagetype' => 'PNG', // not always present
     *                     'picturetype' => 'Other',
     *                     'description' => '',
     *                     'datalength' => 7627,
     *                     ]
     *
     * @return string
     */
    public function generateCover(array $cover);

    /**
     * @return string
     */
    public function getUploadRootDirectory();

    /**
     * @return string
     */
    public function getWebDirectory();

    /**
     * @return string
     */
    public function getUploadDirectory();

    /**
     * @return SongInterface[]
     */
    public function getSongs();

    /**
     * @param SongInterface[] $songs
     *
     * @return AlbumInterface
     */
    public function setSongs($songs);

    /**
     * @param SongInterface $song
     *
     * @return AlbumInterface
     */
    public function addSong(SongInterface $song);

    /**
     * @return ArtistInterface
     */
    public function getArtist();

    /**
     * @param mixed $artists
     *
     * @return AlbumInterface
     */
    public function setArtist($artists);

    /**
     * @return mixed
     */
    public function getReleaseDate();

    /**
     * @param mixed $releaseDate
     *
     * @return AlbumInterface
     */
    public function setReleaseDate($releaseDate);

    /**
     * @return mixed
     */
    public function getMusicBrainzId();

    /**
     * @param mixed $musicBrainzId
     *
     * @return AlbumInterface
     */
    public function setMusicBrainzId($musicBrainzId);

    /**
     * @return string
     */
    public function getLastFmId();

    /**
     * @param string $lastFmId
     *
     * @return AlbumInterface
     */
    public function setLastFmId($lastFmId);

    /**
     * @return string
     */
    public function getLastFmUrl();

    /**
     * @param string $lastFmUrl
     *
     * @return AlbumInterface
     */
    public function setLastFmUrl($lastFmUrl);
}
