<?php

namespace BlackSheep\MusicLibraryBundle\Model;

/**
 * Interface GenreCollectionInterface.
 */
interface GenreCollectionInterface
{
    /**
     * @return GenreInterface[]
     */
    public function getGenres();

    /**
     * @param GenreInterface[] $genres
     *
     * @return AlbumInterface
     */
    public function setGenres($genres);

    /**
     * @param GenreInterface $genre
     *
     * @return AlbumInterface
     */
    public function addGenre(GenreInterface $genre);

    /**
     * @param GenreInterface $genre
     *
     * @return $this
     */
    public function removeGenre(GenreInterface $genre);
}
