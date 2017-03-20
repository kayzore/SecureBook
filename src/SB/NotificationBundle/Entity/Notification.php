<?php

namespace SB\NotificationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SB\UserBundle\Entity\User;

/**
 * Notification
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SB\NotificationBundle\Entity\NotificationRepository")
 */
class Notification
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="SB\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userFrom;

    /**
     * @ORM\ManyToOne(targetEntity="SB\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userTo;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=20)
     */
    private $type;

    /**
     * @var boolean
     *
     * @ORM\Column(name="view", type="boolean")
     */
    private $view;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Notification
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set view
     *
     * @param boolean $view
     * @return Notification
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Get view
     *
     * @return boolean 
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Set userFrom
     *
     * @param \SB\UserBundle\Entity\User $userFrom
     * @return Notification
     */
    public function setUserFrom(User $userFrom)
    {
        $this->userFrom = $userFrom;

        return $this;
    }

    /**
     * Get userFrom
     *
     * @return \SB\UserBundle\Entity\User 
     */
    public function getUserFrom()
    {
        return $this->userFrom;
    }

    /**
     * Set userTo
     *
     * @param \SB\UserBundle\Entity\User $userTo
     * @return Notification
     */
    public function setUserTo(User $userTo)
    {
        $this->userTo = $userTo;

        return $this;
    }

    /**
     * Get userTo
     *
     * @return \SB\UserBundle\Entity\User 
     */
    public function getUserTo()
    {
        return $this->userTo;
    }
}
