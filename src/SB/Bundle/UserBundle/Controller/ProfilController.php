<?php

namespace SB\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProfilController extends Controller
{
    public function profilAction($slugUsername)
    {
        $user = $this->getUser();
        if ($user->getSlug() != $slugUsername) {
            $this->friendProfilAction($slugUsername);
        }




        return $this->render('SBCoreBundle:Profil:profil.html.twig', array(
            'notifications'         => $user->getNotifications()
        ));
    }

    private function friendProfilAction($slugUsername)
    {
        $em = $this->getDoctrine()->getManager();

        return $this->render('SBCoreBundle:Profil:friend_profil.html.twig');
    }
}