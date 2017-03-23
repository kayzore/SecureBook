<?php

namespace SB\Bundle\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Confidentiality
 *
 * @ORM\Table(name="confidentiality")
 * @ORM\Entity(repositoryClass="SB\Bundle\UserBundle\Repository\ConfidentialityRepository")
 */
class Confidentiality
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="firstname", type="boolean")
     */
    private $firstname;

    /**
     * @var bool
     *
     * @ORM\Column(name="lastname", type="boolean")
     */
    private $lastname;

    /**
     * @var bool
     *
     * @ORM\Column(name="pays", type="boolean")
     */
    private $pays;

    /**
     * @var bool
     *
     * @ORM\Column(name="region", type="boolean")
     */
    private $region;

    /**
     * @var bool
     *
     * @ORM\Column(name="ville", type="boolean")
     */
    private $ville;

    /**
     * @var bool
     *
     * @ORM\Column(name="avatar", type="boolean")
     */
    private $avatar;

    /**
     * @var bool
     *
     * @ORM\Column(name="cover", type="boolean")
     */
    private $cover;

    /**
     * @var bool
     *
     * @ORM\Column(name="activity", type="boolean")
     */
    private $activity;

    public function __construct()
    {
        $this->firstname = false;
        $this->lastname = false;
        $this->pays = false;
        $this->region = false;
        $this->ville = false;
        $this->avatar = false;
        $this->cover = false;
        $this->activity = false;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstname
     *
     * @param boolean $firstname
     *
     * @return Confidentiality
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return bool
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param boolean $lastname
     *
     * @return Confidentiality
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return bool
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set pays
     *
     * @param boolean $pays
     *
     * @return Confidentiality
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return bool
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set region
     *
     * @param boolean $region
     *
     * @return Confidentiality
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return bool
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set ville
     *
     * @param boolean $ville
     *
     * @return Confidentiality
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return bool
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set avatar
     *
     * @param boolean $avatar
     *
     * @return Confidentiality
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return bool
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set cover
     *
     * @param boolean $cover
     *
     * @return Confidentiality
     */
    public function setCover($cover)
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * Get cover
     *
     * @return bool
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * Set activity
     *
     * @param boolean $activity
     *
     * @return Confidentiality
     */
    public function setActivity($activity)
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * Get activity
     *
     * @return bool
     */
    public function getActivity()
    {
        return $this->activity;
    }
}
