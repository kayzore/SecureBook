<?php

namespace SB\Bundle\ActivityBundle\Utils;

use SB\Bundle\ActivityBundle\Entity\Activity;
use SB\Bundle\ActivityBundle\Form\Type\ActivityType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Routing\Router;

class SBActivity
{
    private $formFactory;
    private $router;

    public function __construct(FormFactory $formFactory, Router $router)
    {
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    public function getForm($route_name)
    {
        return $this->formFactory->create(ActivityType::class, new Activity(), array(
            'action' => $this->router->generate($route_name)
        ));
    }
}