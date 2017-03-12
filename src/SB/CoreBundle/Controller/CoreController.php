<?php

namespace SB\CoreBundle\Controller;

use SB\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
            $user = $em->getRepository('SBUserBundle:User')->find(5);
            return $this->render('SBCoreBundle:Home:index.html.twig', array(
                'list_activity'     => $em->getRepository('SBActivityBundle:Activity')->fetchAll($this->getUser()->getId()),
                //'user'              => $user
            ));
        }
        return $this->render('SBCoreBundle:Home:index.html.twig');
    }
}