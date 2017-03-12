<?php
// src/SB/ActivityBundle/DataFixtures/ORM/LoadActivity.php

namespace SB\ActivityBundle\DataFixtures\ORM;

use DateTime;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SB\ActivityBundle\Entity\Activity;
use SB\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadActivity extends AbstractFixture implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var User
     */
    private $user;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        // Les activités à créer
        $listActivity = array(
            array('Super message de test 1', new DateTime('2000-01-01'), 1),
            array('Super message de test 2', new DateTime('2000-01-02'), 2),
            array('Super message de test 3', new DateTime('2000-01-03'), 3),
            array('Super message de test 4', new DateTime('2000-01-04'), 4),
        );

        foreach ($listActivity as $key =>$activite) {
            $activity = new Activity();
            $activity->setMessage($activite[0]);
            $activity->setDateActivity($activite[1]);
            $this->user = $this->getReference('user' . $key);
            $activity->setUser($this->user);
            $manager->persist($activity);
        }

        $manager->flush();
    }
}