<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibraryBundle\Model;

/**
 * Interface AlbumInterface.
 */
interface AlbumInterface extends ApiInterface, SongCollectionInterface, PlayCountInterface, HasGenreInterface, AlbumArtworkSetInterface, ArtworkCollectionInterface
{
    /**
     * @param $name
     * @param ArtistInterface $artist
     * @param $extraInfo
     *
     * @return AlbumInterface
     */
    public static function createArtistAlbum($name, $artist, $extraInfo);

    /**
     * @return string
     */
    public function getSlug();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     *
     * @return AlbumInterface
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getCover();

    /**
     * @param string $cover
     *
     * @return AlbumInterface
     */
    public function setCover($cover);

    /**
     * @return ArtistInterface
     */
    public function getArtist();

    /**
     * @param ArtistInterface $artist
     *
     * @return $this
     */
    public function setArtist(ArtistInterface $artist);

    /**
     * @return string
     */
    public function getReleaseDate();

    /**
     * @param \DateTime $releaseDate
     *
     * @return AlbumInterface
     */
    public function setReleaseDate($releaseDate);

    /**
     * @return string
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
    public function getMusicBrainzReleaseGroupId();

    /**
     * @param string $musicBrainzReleaseGroupId
     */
    public function setMusicBrainzReleaseGroupId(string $musicBrainzReleaseGroupId);

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

    /**
     * @return bool
     */
    public function isLossless();

    /**
     * @return bool
     */
    public function setLossless($lossless);
}
