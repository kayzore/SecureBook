<?php

namespace SB\Bundle\ActivityBundle\Utils;

use Doctrine\ORM\EntityManager;
use SB\Bundle\ActivityBundle\Entity\Comment;
use SB\Bundle\NotificationBundle\Entity\Notification;
use SB\Bundle\UserBundle\Entity\User;

class SBComment
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

    /**
     * @param $comment_text
     * @param $activity_id
     * @param User $user
     * @return string|int
     */
    public function addComment($comment_text, $activity_id, User $user)
    {
        $activity = $this->em->getRepository('SBActivityBundle:Activity')->findOneBy(array('id' => $activity_id));

        $activity->addOneComment();

        $comment = new Comment();
        $comment->setActivity($activity);
        $comment->setUser($user);
        $comment->setText($comment_text);

        if ($user->getUsername() != $activity->getUser()->getUsername()) {
            $channel = '/' . $activity->getUser()->getUsername();
            $data    = array('type' => 'comment', 'text' => $user->getUsername() . ' a commenté une de vos actualité');
            $this->faye->send($channel, $data);

            $notification = new Notification();
            $notification->setUserFrom($user);
            $notification->setUserTo($activity->getUser());
            $notification->setActivity($activity);
            $notification->setType('comment');
            $this->em->persist($notification);
        }

        $this->em->persist($activity);
        $this->em->persist($comment);
        $this->em->flush();

        return $activity->getNbComments();
    }
}
