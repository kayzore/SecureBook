<?php

namespace SB\Bundle\ActivityBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use SB\Bundle\UserBundle\Entity\User;

/**
 * Activity
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SB\Bundle\ActivityBundle\Entity\ActivityRepository")
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
     * @ORM\ManyToOne(targetEntity="SB\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity="SB\Bundle\ActivityBundle\Entity\Image", cascade={"persist"})
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
     * @ORM\OneToMany(targetEntity="SB\Bundle\ActivityBundle\Entity\Likes", mappedBy="activity")
     * @ORM\JoinColumn(nullable=true)
     */
    private $likes;

    /**
     * @var integer
     *
     * @ORM\Column(name="nb_comments", type="integer")
     */
    private $nb_comments;

    /**
     * @ORM\OneToMany(targetEntity="SB\Bundle\ActivityBundle\Entity\Comment", mappedBy="activity")
     * @ORM\JoinColumn(nullable=true)
     */
    private $comments;


    public function __construct()
    {
        $this->dateActivity = new \Datetime();
        $this->likes = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->nb_likes = 0;
        $this->nb_comments = 0;
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
     * @param \SB\Bundle\ActivityBundle\Entity\Image $image
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
     * @return \SB\Bundle\ActivityBundle\Entity\Image
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
     * Set nb like
     *
     * @param integer $nb_likes
     * @return Activity
     */
    public function setNbLike($nb_likes = 0)
    {
        $this->nb_likes = $nb_likes;

        return $this;
    }

    /**
     * Get nb Likes
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

    /**
     * Add one comment
     *
     * @return Activity
     */
    public function addOneComment()
    {
        $this->nb_comments++;

        return $this;
    }

    /**
     * Remove one comment
     *
     * @return Activity
     */
    public function removeOneComment()
    {
        $this->nb_comments--;

        return $this;
    }

    /**
     * Set nb comment
     *
     * @param integer $nb_comments
     * @return Activity
     */
    public function setNbComment($nb_comments = 0)
    {
        $this->nb_comments = $nb_comments;

        return $this;
    }

    /**
     * Get nb comment
     *
     * @return integer
     */
    public function getNbComments()
    {
        return $this->nb_comments;
    }
}
