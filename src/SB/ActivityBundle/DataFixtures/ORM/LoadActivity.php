<?php
// src/SB/ActivityBundle/DataFixtures/ORM/LoadActivity.php

namespace SB\ActivityBundle\DataFixtures\ORM;

use DateTime;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SB\ActivityBundle\Entity\Activity;

class LoadActivity implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // Les activités à créer
        $listActivity = array(
            array('Super message de test 1', new DateTime('2000-01-01')),
            array('Super message de test 2', new DateTime('2000-01-02')),
            array('Super message de test 3', new DateTime('2000-01-03')),
            array('Super message de test 4', new DateTime('2000-01-04')),
        );

        foreach ($listActivity as $activite) {
            // On crée l'activité
            $activity = new Activity();

            $activity->setMessage($activite[0]);
            $activity->setDateActivity($activite[1]);

            // On le persiste
            $manager->persist($activity);
        }

        // On déclenche l'enregistrement
        $manager->flush();
    }
}