<?php
// src/SB/ActivityBundle/DataFixtures/ORM/LoadActivity.php

namespace SB\ActivityBundle\DataFixtures\ORM;

use DateTime;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SB\Bundle\ActivityBundle\Entity\Activity;
use SB\Bundle\UserBundle\Entity\User;

class LoadActivity extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * @var User
     */
    private $user;

    public function load(ObjectManager $manager)
    {
        // Les activités à créer
        $listActivity = array(
            array('Super message de test 1', new DateTime('2017-01-01'), 1),
            array('Super message de test 2', new DateTime('2017-03-02'), 2),
            array('Super message de test 3', new DateTime('2017-03-03'), 3),
            array('Super message de test 4', new DateTime('2017-03-04'), 4),
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

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 2;
    }
}
