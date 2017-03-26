<?php

namespace SB\Bundle\ActivityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CommentController extends Controller
{
    /**
     * TODO: Trim and sanitize message before flush entity
     */
    public function addCommentAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $comment_text = $request->request->get('comment_text');
            $activity_id = $request->request->get('id_activity');
            $user = $this->getUser();
            $activity_comments = $this->container->get('sb_activity.comment')->addComment($comment_text, $activity_id, $user);

            return new JsonResponse(array('activity_comments' => $activity_comments));
        }
        return $this->redirectToRoute('sb_core_homepage');
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
        return $this->redirectToRoute('sb_core_homepage');
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
        return $this->redirectToRoute('sb_core_homepage');
    }
}
