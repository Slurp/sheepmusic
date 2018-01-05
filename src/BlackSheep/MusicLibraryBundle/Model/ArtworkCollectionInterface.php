<?php

namespace BlackSheep\MusicLibraryBundle\Model;

use BlackSheep\MusicLibraryBundle\Model\Media\ArtworkInterface;

/**
 * Interface ArtworkCollectionInterface.
 */
interface ArtworkCollectionInterface
{
    /**
     * @return ArtworkInterface[]
     */
    public function getArtworks();

    /**
     * @param ArtworkInterface[] $artworks
     *
     * @return AlbumInterface
     */
    public function setArtworks($artworks);

    /**
     * @param ArtworkInterface $artwork
     *
     * @return AlbumInterface
     */
    public function addArtwork(ArtworkInterface $artwork);

    /**
     * @param ArtworkInterface $artwork
     *
     * @return $this
     */
    public function removeArtwork(ArtworkInterface $artwork);
}
