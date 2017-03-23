<?php
namespace BlackSheep\MusicLibraryBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * Some useful common functions
 */
class AbstractRepository extends EntityRepository implements AbstractRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function queryAll()
    {
        return $this->createQueryBuilder('a')->getQuery();
    }

    /**
     * @param $entity
     */
    public function save($entity)
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);
    }
}
