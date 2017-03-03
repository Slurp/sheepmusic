<?php

namespace BlackSheep\MusicLibraryBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Some useful common functions.
 */
class AbstractRepository extends EntityRepository implements AbstractRepositoryInterface
{
    /**
     * @param $entity
     */
    public function save($entity)
    {
        $this->getEntityManager()->flush($entity);
        $this->getEntityManager()->persist($entity);
    }
}
