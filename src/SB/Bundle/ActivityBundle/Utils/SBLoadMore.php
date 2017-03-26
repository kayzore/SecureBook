<?php

namespace SB\Bundle\ActivityBundle\Utils;

use Doctrine\ORM\EntityManager;
use SB\Bundle\UserBundle\Entity\User;
use SB\Bundle\UserBundle\Utils\SBFriend;

class SBLoadMore
{
    /**
     * @var EntityManager
     */
    private $em;
    /**
     * @var SBFriend
     */
    private $friend;

    /**
     * SBLoadMore constructor.
     * @param EntityManager $entityManager
     * @param SBFriend $friend
     */
    public function __construct(EntityManager $entityManager, SBFriend $friend)
    {
        $this->em = $entityManager;
        $this->friend = $friend;
    }

    /**
     * Return older activity
     * @param User $user
     * @param int $limit
     * @param int $activity_last_id
     * @param bool $global_activity
     * @return array List of activity
     */
    public function loadOlderActivity(User $user, $limit, $activity_last_id, $global_activity = false)
    {
        if ($global_activity) {
            $list_friends = $this->friend->getFriends($user);
            return $this->em->getRepository('SBActivityBundle:Activity')->fetchAll($user->getId(), $list_friends, $limit, $activity_last_id);
        }

        return $this->em->getRepository('SBActivityBundle:Activity')->fetchAll($user->getId(), array(), $limit, $activity_last_id);
    }
}
