<?php

namespace SB\Bundle\NotificationBundle\Utils;

use Doctrine\ORM\EntityManager;
use SB\Bundle\NotificationBundle\Entity\Notification as NotifEntity;

class Notification
{
    /**
     * @var EntityManager $em
     */
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function setNotificationView(NotifEntity $notification, $view_statut)
    {
        $notification->setView($view_statut);
        $this->em->persist($notification);
        $this->em->flush();
    }
}