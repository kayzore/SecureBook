<?php

namespace SB\Bundle\UserBundle\Controller;

use SB\Bundle\ActivityBundle\Entity\Activity;
use SB\Bundle\UserBundle\Entity\Avatar;
use SB\Bundle\UserBundle\Form\Type\AvatarType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ProfilController extends Controller
{
    public function profilAction($slugUsername)
    {
        $user = $this->getUser();
        if ($user->getSlug() != $slugUsername) {
            return $this->friendProfilAction($slugUsername);
        }
        $form_add_activity = $this->container->get('sb_activity.activity')->getForm(new Activity(), 'sb_activity_profil_add');
        $em = $this->getDoctrine()->getManager();
        $activityRepository = $em->getRepository('SBActivityBundle:Activity');
        $form_avatar = $this->createForm(AvatarType::class, new Avatar($this->get('kernel')->getRootDir()), array(
            'action' => $this->generateUrl('sb_user_profil_update_profil_avatar')
        ));

        return $this->render('SBUserBundle:Profil:profil.html.twig', array(
            'list_activity'         => $activityRepository->fetchAll($user->getId(), array(), 5),
            'number_of_activity'    => $activityRepository->countAll($user->getId(), array()),
            'form_add_activity'     => $form_add_activity->createView(),
            'form_avatar'           => $form_avatar->createView(),
            'notifications'         => $user->getNotifications()
        ));
    }

    private function friendProfilAction($slugUsername)
    {
        $em = $this->getDoctrine()->getManager();

        return $this->render('SBUserBundle:Profil:friend_profil.html.twig');
    }

    public function updateProfilAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $champ = $request->request->get('champ');
            $new_value = $request->request->get('new_value');
            $this->container->get('sb_user.user')->updateProfilInformations($this->getUser(), $champ, $new_value);

            return new JsonResponse(array('result' => true));
        }
        return $this->redirectToRoute('sb_core_homepage');
    }

    public function updateProfilConfidentialityAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $champ = $request->request->get('champ');
            $new_value = $request->request->get('new_value');
            $this->container->get('sb_user.user')->updateProfilConfidentiality($this->getUser(), $champ, $new_value);

            return new JsonResponse(array('result' => true));
        }
        return $this->redirectToRoute('sb_core_homepage');
    }

    public function updateProfilAvatarAction(Request $request)
    {
        $avatar = new Avatar($this->container->get('kernel')->getRootDir());
        $form_avatar = $this->createForm(AvatarType::class, $avatar);
        $form_avatar->handleRequest($request);
        if ($form_avatar->isSubmitted() && $form_avatar->isValid()) {
            $user = $this->getUser();
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('SBUserBundle:User')->findOneBy(array('id' => $user->getId()));

            if (!is_null($avatar->getFile())) {
                $avatar->upload($user->getUsername());
                $user->setAvatar($avatar);
            }

            $em->persist($user);
            $em->persist($avatar);
            $em->flush();

            return $this->redirectToRoute('sb_user_profil', array('slugUsername' => $user->getSlug()));
        }
        return $this->redirectToRoute('sb_core_homepage');
    }
}
