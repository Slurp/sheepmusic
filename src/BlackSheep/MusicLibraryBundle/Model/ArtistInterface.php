<?php

namespace BlackSheep\MusicLibraryBundle\Model;

use BlackSheep\MusicLibraryBundle\MusicBrainz\MusicBrainzModelInterface;

/**
 * Interface AlbumInterface.
 */
interface ArtistInterface extends ApiInterface, MusicBrainzModelInterface, SongCollectionInterface, GenreCollectionInterface, ArtworkCollectionInterface, PlayCountInterface
{
    /**
     * @param      $name
     * @param null $musicBrainzId
     *
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
     *
     * @return ArtistInterface
     */
    public function setName($name);

    /**
     * @return mixed
     */
    public function getImage();

    /**
     * @param mixed $image
     *
     * @return ArtistInterface
     */
    public function setImage($image);

    /**
     * @return mixed
     */
    public function getBiography();

    /**
     * @param mixed $biography
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
     * @return mixed
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
     * @return ArtistInterface[]
     */
    public function getSimilarArtists();

    /**
     * @param ArtistInterface[] $similarArtists
     */
    public function setSimilarArtists($similarArtists);

    /**
     * @param ArtistInterface $similarArtist
     */
    public function addSimilarArtist(self $similarArtist);

    /**
     * @param ArtistInterface $similarArtist
     */
    public function removeSimilarArtist(self $similarArtist);
}
