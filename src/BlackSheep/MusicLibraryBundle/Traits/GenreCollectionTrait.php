<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibraryBundle\Traits;

use BlackSheep\MusicLibraryBundle\Model\GenreInterface;

/**
 * Trait GenreCollectionTrait.
 */
trait GenreCollectionTrait
{
    /**
     * @var GenreInterface[]
     */
    protected $genres;

    /**
     * @return GenreInterface[]
     */
    public function getGenres()
    {
        return $this->genres;
    }

    /**
     * {@inheritdoc}
     */
    public function setGenres($genres)
    {
        $this->genres = $genres;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addGenre(GenreInterface $genre)
    {
        if (in_array($genre, $this->genres, true) === false) {
            $this->genres[] = $genre;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeGenre(GenreInterface $genre)
    {
        if (($key = array_search($genre, $this->genres, true)) !== false) {
            unset($this->genres[$key]);
            $this->genres = array_values($this->genres);
        }

        return $this;
    }
}
