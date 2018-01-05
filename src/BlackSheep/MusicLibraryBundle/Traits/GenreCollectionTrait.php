<?php

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
        if (in_array($genre, $this->genres) === false) {
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
