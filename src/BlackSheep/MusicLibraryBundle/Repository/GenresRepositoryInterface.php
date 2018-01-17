<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibraryBundle\Repository;

use BlackSheep\MusicLibraryBundle\Model\GenreInterface;

/**
 * Interface GenresRepositoryInterface.
 */
interface GenresRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param   $genreName
     *
     * @return GenreInterface|null
     */
    public function addOrUpdateByName($genreName);

    /**
     * @param   $genreName
     *
     * @return null|GenreInterface
     */
    public function getByName($genreName);

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getRecentGenres();
}
