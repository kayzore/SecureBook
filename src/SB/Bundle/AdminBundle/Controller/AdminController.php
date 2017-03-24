<?php

namespace SB\Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function homeAction()
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $em = $this->getDoctrine()->getManager();
            $feedbacks = $em->getRepository('SBAdminBundle:Feedback')->findAll();
            return $this->render('SBAdminBundle:Admin:home.html.twig', array(
                'feedbacks' => $feedbacks
            ));
        }
        return $this->createAccessDeniedException('Acces Denied');
    }
}
