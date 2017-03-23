<?php

namespace SB\Bundle\ActivityBundle\Controller;

use SB\Bundle\ActivityBundle\Entity\Likes;
use SB\Bundle\NotificationBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class LikeController extends Controller
{
    public function addLikeAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $id_activity = $request->request->get('id_activity');
            $user = $this->getUser();

            $em = $this->getDoctrine()->getManager();
            $activity = $em->getRepository('SBActivityBundle:Activity')->findOneBy(array('id' => $id_activity));

            $like = $em->getRepository('SBActivityBundle:Likes')->findOneBy(array(
                'user' => $user,
                'activity' => $activity
            ));

            if (is_null($like)) {
                $activity->addOneLike();

                $likes = new Likes();
                $likes->setActivity($activity);
                $likes->setUser($user);

                if ($user->getUsername() != $activity->getUser()->getUsername()) {
                    $faye = $this->container->get('sb_realtime.faye.client');
                    $channel = '/' . $activity->getUser()->getUsername();
                    $data    = array('type' => 'like', 'text' => $user->getUsername() . ' aime une de vos actualité');
                    $faye->send($channel, $data);
                    $notification = new Notification();
                    $notification->setUserFrom($user);
                    $notification->setUserTo($activity->getUser());
                    $notification->setActivity($activity);
                    $notification->setType('like');
                    $em->persist($notification);
                }
                $em->persist($likes);
                $em->persist($activity);
                $em->flush();
            }
            $activity_likes = $activity->getNbLikes();
            return new JsonResponse(array('activity_likes' => $activity_likes));
        }
        return $this->createAccessDeniedException('Acces Denied');
    }

    public function dislikeAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $id_activity = $request->request->get('id_activity');
            $user = $this->getUser();

            $em = $this->getDoctrine()->getManager();
            $activity = $em->getRepository('SBActivityBundle:Activity')->findOneBy(array('id' => $id_activity));

            $like = $em->getRepository('SBActivityBundle:Likes')->findOneBy(array(
                'user' => $user,
                'activity' => $activity
            ));

            if (!is_null($like)) {
                $activity->removeOneLike();

                $em->remove($like);
                $em->persist($activity);
                $em->flush();
            }
            $activity_likes = $activity->getNbLikes();
            return new JsonResponse(array('activity_likes' => $activity_likes));
        }
        return $this->createAccessDeniedException('Acces Denied');
    }
}