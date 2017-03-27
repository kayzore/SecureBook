<?php

namespace SB\Bundle\UserBundle\Utils;

use Doctrine\ORM\EntityManager;
use SB\Bundle\UserBundle\Entity\User;

class SBUser
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * SBFriend constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function updateProfilInformations(User $user, $champ, $new_value)
    {
        $user = $this->em->getRepository('SBUserBundle:User')->findOneBy(array('id' => $user->getId()));

        if (!empty($champ) && !empty($new_value)) {
            switch ($champ) {
                case 'prenom':
                    $user->setFirstname($new_value);
                    break;
                case 'nom':
                    $user->setLastname($new_value);
                    break;
                case 'pays':
                    $user->setPays($new_value);
                    break;
                case 'region':
                    $user->setRegion($new_value);
                    break;
                case 'ville':
                    $user->setVille($new_value);
                    break;
            }
        }
        $this->em->persist($user);
        $this->em->flush();
    }

    public function updateProfilConfidentiality(User $user, $champ, $new_value)
    {
        $user = $this->em->getRepository('SBUserBundle:User')->findOneBy(array('id' => $user->getId()));

        if (!empty($champ) && !empty($new_value)) {
            if ($new_value == 'true') {
                $new_value = true;
            } elseif ($new_value == 'false') {
                $new_value = false;
            }
            switch ($champ) {
                case 'prenom':
                    $user->getConfidentiality()->setFirstnameConf($new_value);
                    break;
                case 'nom':
                    $user->getConfidentiality()->setLastnameConf($new_value);
                    break;
                case 'pays':
                    $user->getConfidentiality()->setPaysConf($new_value);
                    break;
                case 'region':
                    $user->getConfidentiality()->setRegionConf($new_value);
                    break;
                case 'ville':
                    $user->getConfidentiality()->setVilleConf($new_value);
                    break;
                case 'avatar':
                    $user->getConfidentiality()->setAvatarConf($new_value);
                    break;
            }
        }
        $this->em->persist($user);
        $this->em->flush();
    }

}
