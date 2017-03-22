<?php

namespace SB\Bundle\UserBundle\Controller;

use SB\Bundle\ActivityBundle\Entity\Activity;
use SB\Bundle\ActivityBundle\Form\Type\ActivityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProfilController extends Controller
{
    public function profilAction($slugUsername)
    {
        $user = $this->getUser();
        if ($user->getSlug() != $slugUsername) {
            $this->friendProfilAction($slugUsername);
        }
        $em = $this->getDoctrine()->getManager();
        $activity = new Activity();
        $form_add_activity = $this->createForm(ActivityType::class, $activity, array(
            'action' => $this->generateUrl('sb_activity_add')
        ));
        $activityRepository = $em->getRepository('SBActivityBundle:Activity');



        return $this->render('SBCoreBundle:Profil:profil.html.twig', array(
            'list_activity'         => $activityRepository->fetchAll($user->getId(), array(), 5),
            'number_of_activity'    => $activityRepository->countAll($user->getId(), array()),
            'form_add_activity'     => $form_add_activity->createView(),
            'notifications'         => $user->getNotifications()
        ));
    }

    private function friendProfilAction($slugUsername)
    {
        $em = $this->getDoctrine()->getManager();

        return $this->render('SBCoreBundle:Profil:friend_profil.html.twig');
    }
}