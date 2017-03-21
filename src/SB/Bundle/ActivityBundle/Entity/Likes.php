<?php

namespace SB\Bundle\ActivityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SB\Bundle\UserBundle\Entity\User;

/**
 * Likes
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SB\Bundle\ActivityBundle\Entity\LikesRepository")
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
     * @ORM\ManyToOne(targetEntity="SB\Bundle\ActivityBundle\Entity\Activity", inversedBy="likes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activity;

    /**
     * @ORM\ManyToOne(targetEntity="SB\Bundle\UserBundle\Entity\User")
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
     * @param \SB\Bundle\ActivityBundle\Entity\Activity $activity
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
     * @return \SB\Bundle\ActivityBundle\Entity\Activity
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * Set user
     *
     * @param \SB\Bundle\UserBundle\Entity\User $user
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
     * @return \SB\Bundle\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
