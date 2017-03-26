<?php

namespace SB\Bundle\ActivityBundle\Utils;

use Doctrine\ORM\EntityManager;
use SB\Bundle\ActivityBundle\Entity\Likes;
use SB\Bundle\NotificationBundle\Entity\Notification;
use SB\Bundle\UserBundle\Entity\User;

class SBLike
{
    /**
     * @var EntityManager
     */
    private $em;
    private $faye;

    /**
     * SBActivity constructor.
     * @param EntityManager $entityManager
     * @param $faye_client
     */
    public function __construct(EntityManager $entityManager, $faye_client)
    {
        $this->em   = $entityManager;
        $this->faye = $faye_client;
    }

    public function addLike($id_activity, User $user)
    {
        $activity = $this->em->getRepository('SBActivityBundle:Activity')->findOneBy(array('id' => $id_activity));

        $like = $this->em->getRepository('SBActivityBundle:Likes')->findOneBy(array(
            'user' => $user,
            'activity' => $activity
        ));

        if (is_null($like)) {
            $activity->addOneLike();

            $likes = new Likes();
            $likes->setActivity($activity);
            $likes->setUser($user);

            if ($user->getUsername() != $activity->getUser()->getUsername()) {
                $channel = '/' . $activity->getUser()->getUsername();
                $data    = array('type' => 'like', 'text' => $user->getUsername() . ' aime une de vos actualité');
                $this->faye->send($channel, $data);
                $notification = new Notification();
                $notification->setUserFrom($user);
                $notification->setUserTo($activity->getUser());
                $notification->setActivity($activity);
                $notification->setType('like');
                $this->em->persist($notification);
            }
            $this->em->persist($likes);
            $this->em->persist($activity);
            $this->em->flush();
        }
        return $activity->getNbLikes();
    }
}