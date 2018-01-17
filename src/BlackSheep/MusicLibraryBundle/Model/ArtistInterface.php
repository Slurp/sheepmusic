<?php

namespace BlackSheep\MusicLibraryBundle\Model;

use BlackSheep\MusicLibraryBundle\MusicBrainz\MusicBrainzModelInterface;

/**
 * Interface AlbumInterface.
 */
interface ArtistInterface extends ApiInterface, MusicBrainzModelInterface, SongCollectionInterface, GenreCollectionInterface, ArtworkCollectionInterface, PlayCountInterface, ArtworkSetInterface
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
     * @return integer
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
     * @return void
     */
    public function setSimilarArtists($similarArtists);

    /**
     * @param ArtistInterface $similarArtist
     * @return Artist
     */
    public function addSimilarArtist(self $similarArtist);

    /**
     * @param ArtistInterface $similarArtist
     * @return Artist
     */
    public function removeSimilarArtist(self $similarArtist);
}
