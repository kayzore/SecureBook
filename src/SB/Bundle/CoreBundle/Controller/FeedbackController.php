<?php

namespace SB\Bundle\CoreBundle\Controller;

use SB\Bundle\AdminBundle\Entity\Feedback;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FeedbackController extends Controller
{
    public function addAction(Request $request)
    {
        /**
         * @see http://feedbacknow.tuyoshi.com.br/
         */
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') && $request->isXmlHttpRequest()) {
            $result = json_decode($request->request->get('feedback'), true);
            if (!empty($result)){
                unset($result['html']);
                $feedback = new Feedback();
                $feedback->setUser($this->getUser());
                $feedback->setBrowserData($result['browser']);
                $feedback->setImgData($result['img']);
                $feedback->setNote($result['note']);
                $feedback->setUrl($result['url']);
                $em = $this->getDoctrine()->getManager();
                $em->persist($feedback);
                $em->flush();
                return new JsonResponse(array('add_feedback' => true));
            }
        }
        return $this->createAccessDeniedException('Acces Denied');
    }
}