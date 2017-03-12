<?php

namespace SB\ActivityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
}
