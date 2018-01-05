<?php

namespace BlackSheep\MusicLibraryBundle\Model;

/**
 * Interface hasGenreInterface.
 */
interface HasGenreInterface
{
    /**
     * @return GenreInterface
     */
    public function getGenre();

    /**
     * @param GenreInterface $genre
     */
    public function setGenre(GenreInterface $genre);
}
