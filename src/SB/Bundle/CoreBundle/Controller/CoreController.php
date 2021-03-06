<?php

namespace SB\Bundle\CoreBundle\Controller;

use SB\Bundle\ActivityBundle\Entity\Activity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CoreController extends Controller
{
    public function indexAction()
    {
        /*
        $user = $em->getRepository('SBUserBundle:User')->find(5);
        $user->addFriend(3);
        $em->persist($user);
        $em->flush();
        */
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->getUser();
            $em = $this->getDoctrine()->getManager();
            $list_friends = $this->container->get('sb_user.friend')->getFriends($user);
            $form_add_activity = $this->container->get('sb_activity.activity')->getForm(new Activity(), 'sb_activity_add');
            $activityRepository = $em->getRepository('SBActivityBundle:Activity');
            return $this->render('SBCoreBundle:Home:membre_accueil.html.twig', array(
                'list_activity'         => $activityRepository->fetchAll($user->getId(), $list_friends, 5),
                'number_of_activity'    => $activityRepository->countAll($user->getId(), $list_friends),
                'form_add_activity'     => $form_add_activity->createView(),
                'notifications'         => $user->getNotifications()
            ));
        }
        return $this->render('SBCoreBundle:Home:public_accueil.html.twig');
    }
}
