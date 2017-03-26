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
         * @see https://github.com/jacobscarter/angular-feedback
         */
        if ($request->isXmlHttpRequest()) {
            $result = json_decode($this->get("request")->getContent(), true);
            if (!empty($result['feedback'])){
                unset($result['html']);
                $feedback = new Feedback();
                $feedback->setUser($this->getUser());
                $feedback->setBrowserData($result['feedback']['browser']);
                $feedback->setImgData($result['feedback']['img']);
                $feedback->setNote($result['feedback']['note']);
                $feedback->setUrl($result['feedback']['url']);
                $em = $this->getDoctrine()->getManager();
                $em->persist($feedback);
                $em->flush();
                return new JsonResponse(array('add_feedback' => true));
            }
        }
        return $this->createAccessDeniedException('Acces Denied');
    }
}
