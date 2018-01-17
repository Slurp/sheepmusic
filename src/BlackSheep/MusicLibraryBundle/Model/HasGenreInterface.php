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
