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

use Doctrine\ORM\Query;

/**
 * Interface AbstractRepositoryInterface.
 */
interface AbstractRepositoryInterface
{
    /**
     * @return Query
     */
    public function queryAll();

    /**
     * @return array
     */
    public function getList();

    /**
     * @param mixed $ids
     *
     * @return array
     */
    public function findById($ids);

    /**
     * @param $entity
     */
    public function update($entity = null);

    /**
     * @param $entity
     */
    public function save($entity);

    /**
     * @param $entity
     */
    public function remove($entity);
}
