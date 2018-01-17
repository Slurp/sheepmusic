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
