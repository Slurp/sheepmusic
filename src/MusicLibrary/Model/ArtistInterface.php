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

use BlackSheep\MusicLibrary\Model\SimilarArtist\SimilarArtistsInterface;
use BlackSheep\MusicLibrary\MusicBrainz\MusicBrainzModelInterface;

/**
 * Interface AlbumInterface.
 */
interface ArtistInterface extends ApiInterface, MusicBrainzModelInterface, SongCollectionInterface, GenreCollectionInterface, ArtworkCollectionInterface, PlayCountInterface, ArtistArtworkSetInterface
{
    /**
     * @param      $name
     * @param null $musicBrainzId
     *
     * @return ArtistInterface
     */
    public static function createNew($name, $musicBrainzId = null);

    /**
     * @return string
     */
    public function getSlug();

    /**
     * @return string
     */
    public function getAlias();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     *
     * @return ArtistInterface
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getImage();

    /**
     * @param string $image
     *
     * @return ArtistInterface
     */
    public function setImage($image);

    /**
     * @return string
     */
    public function getBiography();

    /**
     * @param string $biography
     *
     * @return ArtistInterface
     */
    public function setBiography($biography);

    /**
     * @return AlbumInterface[]
     */
    public function getAlbums();

    /**
     * @param AlbumInterface[] $albums
     *
     * @return ArtistInterface
     */
    public function setAlbums($albums);

    /**
     * @return int
     */
    public function getPlayCount();

    /**
     * @param mixed $playCount
     *
     * @return ArtistInterface
     */
    public function setPlayCount($playCount);

    /**
     * @return mixed
     */
    public function getAlbumArt();

    /**
     * @return SimilarArtistsInterface[]
     */
    public function getSimilarArtists();

    /**
     * @param SimilarArtistsInterface[] $similarArtists
     */
    public function setSimilarArtists($similarArtists);

    /**
     * @param SimilarArtistsInterface $similarArtist
     *
     * @return ArtistInterface
     */
    public function addSimilarArtist(SimilarArtistsInterface $similarArtist);

    /**
     * @param SimilarArtistsInterface $similarArtist
     *
     * @return ArtistInterface
     */
    public function removeSimilarArtist(SimilarArtistsInterface $similarArtist);
}
