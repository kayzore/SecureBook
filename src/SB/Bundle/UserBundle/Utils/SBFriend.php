<?php

namespace SB\Bundle\UserBundle\Utils;

use Doctrine\ORM\EntityManager;
use SB\Bundle\UserBundle\Entity\User;

class SBFriend
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getFriends(User $user)
    {
        return $this
            ->em
            ->getRepository('SBUserBundle:User')
            ->findBy(array('id' => $user->getFriends()));
    }
}