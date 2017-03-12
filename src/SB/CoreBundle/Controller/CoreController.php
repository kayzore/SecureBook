<?php

namespace SB\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CoreController extends Controller
{
    public function indexAction()
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $em = $this->get('doctrine')->getManager();
            $user = $this->getUser();
            return $this->render('SBCoreBundle:Home:index.html.twig', array(
                'list_activity' => $em->getRepository('SBActivityBundle:Activity')->fetchAll($user->getId())
            ));
        }
        return $this->render('SBCoreBundle:Home:index.html.twig');
    }
}