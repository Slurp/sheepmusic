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

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Some useful common functions.
 */
abstract class AbstractRepository extends ServiceEntityRepository implements AbstractRepositoryInterface
{
    /**
     * @var array
     */
    protected $listSelection = ['a.id', 'a.slug', 'a.name', 'a.createdAt', 'a.updatedAt', 'a.playCount'];

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, static::getEntityClass());
    }

    /**
     * @return string
     */
    abstract protected static function getEntityClass(): string;

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
     * {@inheritdoc}
     */
    public function findById($ids)
    {
        return $this->findBy(['id' => $ids]);
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
