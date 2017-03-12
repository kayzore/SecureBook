<?php

namespace SB\ActivityBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ActivityRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ActivityRepository extends EntityRepository
{
    public function fetchAll($id_user)
    {
        $qb = $this->createQueryBuilder('a');

        $qb
            ->where('a.id = :id')
            ->setParameter('id', $id_user)
        ;

        return $qb->getQuery()->getResult();
    }
}
