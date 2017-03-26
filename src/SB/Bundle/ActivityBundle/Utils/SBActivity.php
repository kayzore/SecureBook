<?php

namespace SB\Bundle\ActivityBundle\Utils;

use Doctrine\ORM\EntityManager;
use SB\Bundle\ActivityBundle\Entity\Activity;
use SB\Bundle\ActivityBundle\Form\Type\ActivityType;
use SB\Bundle\UserBundle\Entity\User;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Routing\Router;

class SBActivity
{
    /**
     * @var FormFactory
     */
    private $formFactory;
    /**
     * @var Router
     */
    private $router;
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * SBActivity constructor.
     * @param FormFactory $formFactory
     * @param Router $router
     * @param EntityManager $entityManager
     */
    public function __construct(FormFactory $formFactory, Router $router, EntityManager $entityManager)
    {
        $this->formFactory  = $formFactory;
        $this->router       = $router;
        $this->em           = $entityManager;
    }

    /**
     * Return form of activity
     * @param Activity $activity
     * @param string $route_name Alias of route
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getForm(Activity $activity, $route_name = null)
    {
        if (is_null($route_name)) {
            return $this->formFactory->create(ActivityType::class, $activity);
        }
        return $this->formFactory->create(ActivityType::class, $activity, array(
            'action' => $this->router->generate($route_name)
        ));
    }

    /**
     * Add one activity
     * @param User $user
     * @param Activity $activity
     */
    public function addActivity(User $user, Activity $activity)
    {
        $activity->setUser($user);

        if (!is_null($activity->getImage()->getFile())) {
            $activity->getImage()->upload($user->getUsername());
        } else {
            $activity->setImage(null);
        }

        $this->em->persist($activity);
        $this->em->flush();
    }
}
