<?php

namespace SB\CoreBundle\Controller;

use SB\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CoreController extends Controller
{
    public function indexAction()
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $em = $this->get('doctrine')->getManager();
            /*
            $user = $em->getRepository('SBUserBundle:User')->find(5);
            $user->addFriend(3);
            $em->persist($user);
            $em->flush();
            */
            $user = $this->getUser();
            $list_friends = $em->getRepository('SBUserBundle:User')->findBy(array('id' => $user->getFriends()));
            return $this->render('SBCoreBundle:Home:membre_accueil.html.twig', array(
                'list_activity'     => $em->getRepository('SBActivityBundle:Activity')->fetchAll($user->getId(), $list_friends, 5),
                'user'              => $user->getFriends()
            ));
        }
        return $this->render('SBCoreBundle:Home:public_accueil.html.twig');
    }

    public function activityAddAction(Request $request)
    {
        var_dump($request);
    }
}