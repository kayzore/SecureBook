<?php

namespace SB\Bundle\CoreBundle\Controller;

use SB\Bundle\ActivityBundle\Entity\Activity;
use SB\Bundle\ActivityBundle\Form\Type\ActivityType;
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
            $list_friends = $em->getRepository('SBUserBundle:User')->findBy(array('id' => $user->getFriends()));
            $activity = new Activity();
            $form_add_activity = $this->createForm(ActivityType::class, $activity, array(
                'action' => $this->generateUrl('sb_activity_add')
            ));
            return $this->render('SBCoreBundle:Home:membre_accueil.html.twig', array(
                'list_activity'         => $em->getRepository('SBActivityBundle:Activity')->fetchAll($user->getId(), $list_friends, 5),
                'form_add_activity'     => $form_add_activity->createView(),
                'notifications'         => $user->getNotifications()
            ));
        }
        return $this->render('SBCoreBundle:Home:public_accueil.html.twig');
    }
}