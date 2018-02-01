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

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\Query;

/**
 * Some useful common functions.
 */
class AbstractRepository extends EntityRepository implements AbstractRepositoryInterface
{
    /**
     * @var array
     */
    protected $listSelection = ['a.id', 'a.slug', 'a.name', 'a.createdAt', 'a.updatedAt', 'a.playCount'];

    /**
     * {@inheritdoc}
     */
    public function queryAll()
    {
        return $this->createQueryBuilder('a')->getQuery();
    }

    /**
     * @return array
     */
    public function getList()
    {
        return $this->createQueryBuilder('a')->select(
            $this->listSelection
        )->getQuery()->execute(
            [],
            Query::HYDRATE_ARRAY
        );
    }

    /**
     * @param $entity
     *
     * @throws OptimisticLockException
     */
    public function save($entity)
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);
    }

    /**
     * @param $entity
     *
     * @throws OptimisticLockException
     */
    public function update($entity = null)
    {
        $this->getEntityManager()->flush($entity);
    }

    /**
     * @param $entity
     *
     * @throws OptimisticLockException
     */
    public function remove($entity)
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush($entity);
    }
}
