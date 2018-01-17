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
trait HasGenreTrait
{
    /**
     * @var GenreInterface
     */
    protected $genre;

    /**
     * {@inheritdoc}
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * {@inheritdoc}
     */
    public function setGenre(GenreInterface $genre)
    {
        $this->genre = $genre;
    }
}
