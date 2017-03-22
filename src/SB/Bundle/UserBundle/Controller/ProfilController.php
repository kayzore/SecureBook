<?php

namespace SB\Bundle\UserBundle\Controller;

use SB\Bundle\ActivityBundle\Entity\Activity;
use SB\Bundle\ActivityBundle\Form\Type\ActivityType;
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

    public function updateProfilAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $prenom = $request->request->get('prenom');
            $nom = $request->request->get('nom');
            $pays = $request->request->get('pays');
            $region = $request->request->get('region');
            $ville = $request->request->get('ville');

            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('SBUserBundle:User')->findOneBy(array('id' => $this->getUser()->getId()));

            if (!empty($prenom)) {
                $user->setFirstname($prenom);
            }
            if (!empty($nom)) {
                $user->setLastname($nom);
            }
            if (!empty($pays)) {
                $user->setPays($pays);
            }
            if (!empty($region)) {
                $user->setRegion($region);
            }
            if (!empty($ville)) {
                $user->setVille($ville);
            }
            $em->persist($user);
            $em->flush();
            return new JsonResponse(array('result' => true));
        }
        return $this->createAccessDeniedException('Acces Denied');
    }
}