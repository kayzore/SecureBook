<?php

namespace SB\Bundle\UserBundle\Controller;

use SB\Bundle\ActivityBundle\Entity\Activity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ProfilController extends Controller
{
    public function profilAction($slugUsername)
    {
        $user = $this->getUser();
        if ($user->getSlug() != $slugUsername) {
            $this->friendProfilAction($slugUsername);
        }
        $form_add_activity = $this->container->get('sb_activity.activity')->getForm(new Activity(), 'sb_activity_profil_add');
        $em = $this->getDoctrine()->getManager();
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

    public function updateProfilAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $champ = $request->request->get('champ');
            $new_value = $request->request->get('new_value');

            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('SBUserBundle:User')->findOneBy(array('id' => $this->getUser()->getId()));

            if (!empty($champ) && !empty($new_value)) {
                switch ($champ) {
                    case 'prenom':
                        $user->setFirstname($new_value);
                        break;
                    case 'nom':
                        $user->setLastname($new_value);
                        break;
                    case 'pays':
                        $user->setPays($new_value);
                        break;
                    case 'region':
                        $user->setRegion($new_value);
                        break;
                    case 'ville':
                        $user->setVille($new_value);
                        break;
                }
            }
            $em->persist($user);
            $em->flush();
            return new JsonResponse(array('result' => true));
        }
        return $this->createAccessDeniedException('Acces Denied');
    }

    public function updateProfilConfidentialityAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $champ = $request->request->get('champ');
            $new_value = $request->request->get('new_value');
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('SBUserBundle:User')->findOneBy(array('id' => $this->getUser()->getId()));

            if (!empty($champ) && !empty($new_value)) {
                if ($new_value == 'true') {
                    $new_value = true;
                } elseif ($new_value == 'false') {
                    $new_value = false;
                }
                switch ($champ) {
                    case 'prenom':
                        $user->getConfidentiality()->setFirstname($new_value);
                        break;
                    case 'nom':
                        $user->getConfidentiality()->setLastname($new_value);
                        break;
                    case 'pays':
                        $user->getConfidentiality()->setPays($new_value);
                        break;
                    case 'region':
                        $user->getConfidentiality()->setRegion($new_value);
                        break;
                    case 'ville':
                        $user->getConfidentiality()->setVille($new_value);
                        break;
                }
            }
            $em->persist($user);
            $em->flush();
            return new JsonResponse(array('result' => true));
        }
        return $this->createAccessDeniedException('Acces Denied');
    }
}