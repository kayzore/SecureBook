<?php

namespace SB\Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function homeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $feedbacks = $em->getRepository('SBAdminBundle:Feedback')->findAll();
        return $this->render('SBAdminBundle:Admin:home.html.twig', array(
            'feedbacks' => $feedbacks
        ));
    }
}
