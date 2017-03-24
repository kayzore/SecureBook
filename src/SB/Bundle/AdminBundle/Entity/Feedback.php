<?php

namespace SB\Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SB\Bundle\UserBundle\Entity\User;

/**
 * Feedback
 *
 * @ORM\Table(name="feedback")
 * @ORM\Entity(repositoryClass="SB\Bundle\AdminBundle\Repository\FeedbackRepository")
 */
class Feedback
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
     * @var string
     *
     * @ORM\Column(name="img_data", type="text")
     */
    private $imgData;

    /**
     * @var string
     *
     * @ORM\Column(name="browser_data", type="array")
     */
    private $browserData = array();

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="text")
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="text")
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity="SB\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;


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
     * Set imgData
     *
     * @param string $imgData
     *
     * @return Feedback
     */
    public function setImgData($imgData)
    {
        $this->imgData = $imgData;

        return $this;
    }

    /**
     * Get imgData
     *
     * @return string
     */
    public function getImgData()
    {
        return $this->imgData;
    }

    /**
     * Set browserData
     *
     * @param array $browserData
     *
     * @return Feedback
     */
    public function setBrowserData($browserData)
    {
        $this->browserData = $browserData;

        return $this;
    }

    /**
     * Get browserData
     *
     * @return array
     */
    public function getBrowserData()
    {
        return $this->browserData;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Feedback
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set note
     *
     * @param string $note
     *
     * @return Feedback
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set user
     *
     * @param \SB\Bundle\UserBundle\Entity\User $user
     *
     * @return Feedback
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
