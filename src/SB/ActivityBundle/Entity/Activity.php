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
     * @ORM\Column(name="message", type="text", nullable=true)
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
     * @ORM\OneToOne(targetEntity="SB\ActivityBundle\Entity\Image", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $image;

    /**
     * @var integer
     *
     * @ORM\Column(name="nb_likes", type="integer")
     */
    private $nb_likes;

    /**
     * @ORM\OneToMany(targetEntity="SB\ActivityBundle\Entity\Likes", mappedBy="activity")
     */
    private $likes;


    public function __construct()
    {
        $this->dateActivity = new \Datetime();
        $this->likes = new ArrayCollection();
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
    public function setMessage($message = null)
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
     * Set image
     *
     * @param \SB\ActivityBundle\Entity\Image $image
     * @return Activity
     */
    public function setImage(Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \SB\ActivityBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add one like
     *
     * @return Activity
     */
    public function addOneLike()
    {
        $this->nb_likes++;

        return $this;
    }

    /**
     * Remove one like
     *
     * @return Activity
     */
    public function removeOneLike()
    {
        $this->nb_likes--;

        return $this;
    }

    /**
     * Set like
     *
     * @param integer $nb_like
     * @return Activity
     */
    public function setNbLike($nb_like)
    {
        $this->nb_likes = $nb_like;

        return $this;
    }

    /**
     * Get Likes
     *
     * @return integer
     */
    public function getNbLikes()
    {
        return $this->nb_likes;
    }

    /**
     * @param Likes $like
     * @return $this
     */
    public function addLike(Likes $like)
    {
        $this->likes[] = $like;
        $like->setActivity($this);

        return $this;
    }

    /**
     * @param Likes $like
     */
    public function removeLike(Likes $like)
    {
        $this->likes->removeElement($like);
    }

    /**
     * @return ArrayCollection
     */
    public function getLikes()
    {
        return $this->likes;
    }
}
