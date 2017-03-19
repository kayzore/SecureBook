<?php

namespace SB\CoreBundle\Controller;

use SB\ActivityBundle\Entity\Activity;
use SB\ActivityBundle\Entity\Likes;
use SB\ActivityBundle\Form\Type\ActivityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CoreController extends Controller
{
    public function indexAction()
    {
        /*
        $user = $em->getRepository('SBUserBundle:User')->find(5);
        $user->addFriend(3);
        $em->persist($user);
        $em->flush();
        */
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->getUser();
            $em = $this->getDoctrine()->getManager();
            $list_friends = $em->getRepository('SBUserBundle:User')->findBy(array('id' => $user->getFriends()));
            $activity = new Activity();
            $form_add_activity = $this->createForm(new ActivityType(), $activity, array(
                'action' => $this->generateUrl('sb_activity_add')
            ));
            return $this->render('SBCoreBundle:Home:membre_accueil.html.twig', array(
                'list_activity'         => $em->getRepository('SBActivityBundle:Activity')->fetchAll($user->getId(), $list_friends, 5),
                'form_add_activity'     => $form_add_activity->createView()
            ));
        }
        return $this->render('SBCoreBundle:Home:public_accueil.html.twig');
    }

    public function activityAddAction(Request $request)
    {
        $activity = new Activity();
        $form = $this->createForm(new ActivityType(), $activity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $activity->setUser($this->getUser());
            $activity->setLike(0);

            if (!is_null($activity->getImage()->getFile())) {
                $activity->getImage()->upload();
            } else {
                $activity->setImage(null);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($activity);
            $em->flush();
            return $this->redirectToRoute('sb_core_homepage');
        }
        return $this->createAccessDeniedException('Acces Denied');
    }

    public function activityLikeAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $id_activity = $request->request->get('id_activity');
            $user = $this->getUser();

            $em = $this->getDoctrine()->getManager();
            $activity = $em->getRepository('SBActivityBundle:Activity')->findOneBy(array('id' => $id_activity));

            $like = $em->getRepository('SBActivityBundle:Likes')->findOneBy(array(
                'user' => $user,
                'activity' => $activity
            ));

            if (is_null($like)) {
                $activity->addOneLike();

                $likes = new Likes();
                $likes->setActivity($activity);
                $likes->setUser($user);

                $em->persist($likes);
                $em->persist($activity);
                $em->flush();
            }
            $activity_likes = $activity->getNbLikes();
            return new JsonResponse(array('activity_likes' => $activity_likes));
        }
        return $this->createAccessDeniedException('Acces Denied');
    }

    public function activityDislikeAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $id_activity = $request->request->get('id_activity');
            $user = $this->getUser();

            $em = $this->getDoctrine()->getManager();
            $activity = $em->getRepository('SBActivityBundle:Activity')->findOneBy(array('id' => $id_activity));

            $like = $em->getRepository('SBActivityBundle:Likes')->findOneBy(array(
                'user' => $user,
                'activity' => $activity
            ));

            if (!is_null($like)) {
                $activity->removeOneLike();

                $em->remove($like);
                $em->persist($activity);
                $em->flush();
            }
            $activity_likes = $activity->getNbLikes();
            return new JsonResponse(array('activity_likes' => $activity_likes));
        }
        return $this->createAccessDeniedException('Acces Denied');
    }
}