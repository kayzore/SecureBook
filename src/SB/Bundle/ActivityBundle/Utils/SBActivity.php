<?php

namespace SB\Bundle\ActivityBundle\Utils;

use Doctrine\ORM\EntityManager;
use SB\Bundle\ActivityBundle\Entity\Activity;
use SB\Bundle\ActivityBundle\Form\Type\ActivityType;
use SB\Bundle\CoreBundle\Utils\SBApp;
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
     * @var SBApp
     */
    private $sbApp;

    /**
     * SBActivity constructor.
     * @param FormFactory $formFactory
     * @param Router $router
     * @param EntityManager $entityManager
     * @param SBApp $sbApp
     */
    public function __construct(FormFactory $formFactory, Router $router, EntityManager $entityManager, SBApp $sbApp)
    {
        $this->formFactory  = $formFactory;
        $this->router       = $router;
        $this->em           = $entityManager;
        $this->sbApp        = $sbApp;
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
     * @param string $path
     * @param object $data
     */
    public function addActivity(User $user, Activity $activity, $path, Activity $data)
    {
        $activity->setUser($user);

        if (!is_null($activity->getImage()->getFile())) {
            $activity->getImage()
                ->setPath($path)
                ->upload($user->getUsername())
            ;
        } else {
            $activity->setImage(null);
        }
        $activity->setMessage($this->sbApp->sanitizeValue($data->getMessage()));

        $this->em->persist($activity);
        $this->em->flush();
    }
}
