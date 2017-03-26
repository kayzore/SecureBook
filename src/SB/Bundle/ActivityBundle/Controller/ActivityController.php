<?php

namespace SB\Bundle\ActivityBundle\Controller;

use SB\Bundle\ActivityBundle\Entity\Activity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ActivityController extends Controller
{
    public function addActivityAction(Request $request)
    {
        $activityService = $this->container->get('sb_activity.activity');
        $activity = new Activity();
        $form = $activityService->getForm($activity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->container->get('sb_activity.activity')->addActivity($this->getUser(), $activity);

            return $this->redirectToRoute('sb_core_homepage');
        }
        return $this->createAccessDeniedException('Acces Denied');
    }

    public function addActivityOnProfilAction(Request $request)
    {
        $activityService = $this->container->get('sb_activity.activity');
        $activity = new Activity();
        $form = $activityService->getForm($activity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();

            $activityService->addActivity($user, $activity);

            return $this->redirectToRoute('sb_user_profil', array('slugUsername' => $user->getSlug()));
        }
        return $this->createAccessDeniedException('Acces Denied');
    }

    public function getActivityAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $activity_last_id = (int)$request->request->get('id_last_activity');

            if (is_int($activity_last_id)) {
                $loadmore = $this->container->get('sb_activity.loadmore');
                $activity = $loadmore->loadOlderActivity($this->getUser(), 3, $activity_last_id, true);

                return $this->render('SBActivityBundle:activity:activity.html.twig', array(
                    'list_activity' => $activity
                ));
            }
        }
        return $this->createAccessDeniedException('Acces Denied');
    }

    public function getMyActivityAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $activity_last_id = (int)$request->request->get('id_last_activity');

            if (is_int($activity_last_id)) {
                $loadmore = $this->container->get('sb_activity.loadmore');
                $activity = $loadmore->loadOlderActivity($this->getUser(), 3, $activity_last_id);

                return $this->render('SBActivityBundle:activity:activity.html.twig', array(
                    'list_activity' => $activity
                ));
            }
        }
        return $this->createAccessDeniedException('Acces Denied');
    }

    public function activityViewAction(Activity $activity)
    {
        $em = $this->getDoctrine()->getManager();

        $notifications = $em->getRepository('SBNotificationBundle:Notification')->findBy(array('activity' => $activity));
        if (count($notifications) > 0) {
            foreach ($notifications as $notification) {
                $notification->setView(true);
                $em->persist($notification);
            }
            $em->flush();
        }
        $comments = $em->getRepository('SBActivityBundle:Comment')->fetchAll($activity, 6);
        $nb_comments = $em->getRepository('SBActivityBundle:Comment')->countAll($activity->getId());

        $comments = array_reverse($comments);

        return $this->render('SBActivityBundle:activity:one_activity.html.twig', array(
            'activity'      => $activity,
            'comments'      => $comments,
            'nb_comments'   => $nb_comments,
            'notifications' => $this->getUser()->getNotifications()
        ));
    }
}