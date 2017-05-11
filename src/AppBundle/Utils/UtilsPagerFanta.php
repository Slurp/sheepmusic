<?php
/**
 * @author: @{USER} <stephan@bureaublauwgeel.nl>
 * Date: 22/03/17
 * Time: 23:49
 * @copyright 2017 Bureau Blauwgeel
 * @version 1.0
 */

namespace AppBundle\Utils;

use BlackSheep\MusicLibraryBundle\Repository\AbstractRepositoryInterface;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 *
 */
class UtilsPagerFanta
{
    /**
     * @param AbstractRepositoryInterface $repository
     * @param int $page
     *
     * @return Pagerfanta
     */
    public static function getAllPaged(AbstractRepositoryInterface $repository, $page = 1)
    {
        return static::getByQuery($repository->queryAll(), $page);
    }

    /**
     * @param Query $query
     * @param int $page
     *
     * @return Pagerfanta
     */
    public static function getByQuery(Query $query, $page = 1)
    {
        if (is_int($page) === false) {
            $page = 1;
        }
        $pager = new Pagerfanta(
            new DoctrineORMAdapter(
                $query,
                true
            )
        );
        $pager->setMaxPerPage(50);
        $pager->setCurrentPage($page);

        return $pager;
    }
}
