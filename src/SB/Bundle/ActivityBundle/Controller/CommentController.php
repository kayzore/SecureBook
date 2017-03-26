<?php

namespace SB\Bundle\ActivityBundle\Controller;

use SB\Bundle\ActivityBundle\Entity\Comment;
use SB\Bundle\NotificationBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CommentController extends Controller
{
    public function addCommentAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $comment_text = $request->request->get('comment_text');
            $activity_id = $request->request->get('id_activity');
            $user = $this->getUser();

            $em = $this->getDoctrine()->getManager();
            $activity = $em->getRepository('SBActivityBundle:Activity')->findOneBy(array('id' => $activity_id));

            $activity->addOneComment();

            $comment = new Comment();
            $comment->setActivity($activity);
            $comment->setUser($user);
            $comment->setText($comment_text);

            if ($user->getUsername() != $activity->getUser()->getUsername()) {
                $faye = $this->container->get('sb_realtime.faye.client');
                $channel = '/' . $activity->getUser()->getUsername();
                $data    = array('type' => 'comment', 'text' => $user->getUsername() . ' a commenté une de vos actualité');
                $faye->send($channel, $data);

                $notification = new Notification();
                $notification->setUserFrom($user);
                $notification->setUserTo($activity->getUser());
                $notification->setActivity($activity);
                $notification->setType('comment');
                $em->persist($notification);
            }

            $em->persist($activity);
            $em->persist($comment);
            $em->flush();

            $activity_comments = $activity->getNbComments();
            return new JsonResponse(array('activity_comments' => $activity_comments));
        }
        return $this->createAccessDeniedException('Acces Denied');
    }

    public function activityGetCommentAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $activity_id = $request->request->get('id_activity');

            $em = $this->getDoctrine()->getManager();
            $comments = $em->getRepository('SBActivityBundle:Comment')->fetchAll($activity_id, 3);
            $comments = array_reverse($comments);
            $nb_comments = $em->getRepository('SBActivityBundle:Comment')->countAll($activity_id);

            return $this->render('SBActivityBundle:comments:comment.html.twig', array(
                'comments'      => $comments,
                'nb_comments'   => $nb_comments,
                'ajax'          => true
            ));
        }
        return $this->createAccessDeniedException('Acces Denied');
    }

    public function activityGetMoreCommentsAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $activity_id = $request->request->get('id_activity');
            $comment_id = $request->request->get('id_comment');

            $em = $this->getDoctrine()->getManager();
            $comments = $em->getRepository('SBActivityBundle:Comment')->fetchMore($activity_id, $comment_id, 3);
            $comments = array_reverse($comments);
            $nb_comments = $em->getRepository('SBActivityBundle:Comment')->countAll($activity_id);

            return $this->render('SBActivityBundle:comments:comment.html.twig', array(
                'comments'      => $comments,
                'nb_comments'   => $nb_comments,
                'ajax'          => true
            ));
        }
        return $this->createAccessDeniedException('Acces Denied');
    }
}