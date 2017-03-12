<?php

namespace SB\ActivityBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use SB\UserBundle\Entity\User;

/**
 * Activity
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SB\ActivityBundle\Entity\ActivityRepository")
 */
class Activity
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
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     */
    private $message;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_activity", type="datetime")
     */
    private $dateActivity;

    /**
     * @ORM\ManyToOne(targetEntity="SB\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="SB\ActivityBundle\Entity\Image", mappedBy="activity")
     * @ORM\JoinColumn(nullable=true)
     */
    private $images = null;


    public function __construct()
    {
        $this->dateActivity = new \Datetime();
    }

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
     * Set message
     *
     * @param string $message
     * @return Activity
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set dateActivity
     *
     * @param \DateTime $dateActivity
     * @return Activity
     */
    public function setDateActivity($dateActivity)
    {
        $this->dateActivity = $dateActivity;

        return $this;
    }

    /**
     * Get dateActivity
     *
     * @return \DateTime 
     */
    public function getDateActivity()
    {
        return $this->dateActivity;
    }

    /**
     * Set user
     *
     * @param User $user
     * @return Activity
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add images
     *
     * @param Image $images
     * @return Activity
     */
    public function addImage(Image $images)
    {
        $this->images[] = $images;
        $images->setActivity($this);

        return $this;
    }

    /**
     * Remove images
     *
     * @param Image $images
     */
    public function removeImage(Image $images)
    {
        $this->images->removeElement($images);
        $images->setActivity(null);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }
}
