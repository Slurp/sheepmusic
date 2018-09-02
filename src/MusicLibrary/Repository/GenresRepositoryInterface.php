<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Repository;

use BlackSheep\MusicLibrary\Model\GenreInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Interface GenresRepositoryInterface.
 */
interface GenresRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param string $genreName
     *
     * @return GenreInterface|null
     */
    public function addOrUpdateByName($genreName);

    /**
     * @param string $genreName
     *
     * @return null|GenreInterface
     */
    public function getByName($genreName);

    /**
     * @return QueryBuilder
     */
    public function getRecentGenres();
}
