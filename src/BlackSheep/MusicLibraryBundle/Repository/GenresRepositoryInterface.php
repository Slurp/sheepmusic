<?php

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
