<?php

namespace SB\Bundle\ActivityBundle\Utils;

use Doctrine\ORM\EntityManager;
use SB\Bundle\UserBundle\Entity\User;

class SBLoadMore
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function loadActivity(User $user, $limit, $activity_last_id, $list_friends = null)
    {
        if (!is_null($list_friends)) {
            return $this->em->getRepository('SBActivityBundle:Activity')->fetchAll($user->getId(), $list_friends, $limit, $activity_last_id);
        }

        return $this->em->getRepository('SBActivityBundle:Activity')->fetchAll($user->getId(), array(), $limit, $activity_last_id);
    }
}