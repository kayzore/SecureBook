<?php

namespace SB\ActivityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SB\UserBundle\Entity\User;

/**
 * Likes
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SB\ActivityBundle\Entity\LikesRepository")
 */
class Likes
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
     * @ORM\ManyToOne(targetEntity="SB\ActivityBundle\Entity\Activity", inversedBy="likes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activity;

    /**
     * @ORM\ManyToOne(targetEntity="SB\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;


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
     * Set activity
     *
     * @param \SB\ActivityBundle\Entity\Activity $activity
     * @return Likes
     */
    public function setActivity(Activity $activity)
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * Get activity
     *
     * @return \SB\ActivityBundle\Entity\Activity 
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * Set user
     *
     * @param \SB\UserBundle\Entity\User $user
     * @return Likes
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \SB\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
