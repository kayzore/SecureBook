<?php
// src/SB/UserBundle/DataFixtures/ORM/LoadUser.php

namespace SB\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SB\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUser extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        // Les noms d'utilisateurs à créer
        $listNames = array(
            array('Kayzore', array(2, 3, 4)),
            array('Alexandre', array(1, 3, 4)),
            array('Marine', array(1, 2, 4)),
            array('Anna maria', array(1, 2, 3)),
        );

        foreach ($listNames as $key => $new_user) {
            // On crée l'utilisateur
            $user = new User;

            // Le nom d'utilisateur et le mot de passe sont identiques
            $user->setUsername($new_user[0]);
            $encoder = $this->container->get('security.password_encoder');
            $password = $encoder->encodePassword($user, $new_user[0]);
            $user->setPassword($password);
            $user->setEmail($new_user[0] . '@fakemail.com');

            // On ne se sert pas du sel pour l'instant
            $user->setSalt('');
            // On définit uniquement le role ROLE_USER qui est le role de base
            $user->setRoles(array('ROLE_USER'));

            $user->setFriends($new_user[1]);

            // On le persiste
            $manager->persist($user);
            $this->setReference('user' . $key, $user);
        }

        // On déclenche l'enregistrement
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}