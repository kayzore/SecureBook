<?php

namespace SB\Bundle\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use SB\Bundle\NotificationBundle\Entity\Notification;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SB\Bundle\UserBundle\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="Email déjà enregistrée")
 * @UniqueEntity(fields="username", message="Username déjà enregistré")
 */
class User implements UserInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @Gedmo\Slug(fields={"username"})
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @ORM\Column(name="password", type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     */
    private $lastname;

    /**
     * @ORM\Column(name="pays", type="string", length=255, nullable=true)
     */
    private $pays;

    /**
     * @ORM\Column(name="region", type="string", length=255, nullable=true)
     */
    private $region;

    /**
     * @ORM\Column(name="ville", type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(name="salt", type="string", length=255)
     */
    private $salt;

    /**
     * @ORM\Column(name="roles", type="array")
     */
    private $roles = array();

    /**
     * @ORM\Column(name="friends", type="array")
     */
    private $friends = array();

    /**
     * @ORM\OneToMany(targetEntity="SB\Bundle\NotificationBundle\Entity\Notification", mappedBy="userTo")
     * @ORM\JoinColumn(nullable=true)
     */
    private $notifications;

    /**
     * @ORM\OneToOne(targetEntity="SB\Bundle\UserBundle\Entity\Confidentiality", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $confidentiality;

    /**
     * @ORM\OneToOne(targetEntity="SB\Bundle\UserBundle\Entity\Avatar")
     * @ORM\JoinColumn(nullable=true)
     */
    private $avatar;

    /**
     * @ORM\OneToOne(targetEntity="SB\Bundle\UserBundle\Entity\Cover")
     * @ORM\JoinColumn(nullable=true)
     */
    private $cover;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->notifications = new ArrayCollection();
        $this->confidentiality = new Confidentiality();
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Set roles
     *
     * @param array $roles
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
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
     * Set friends
     *
     * @param array $friends
     * @return User
     */
    public function setFriends($friends)
    {
        $this->friends = $friends;

        return $this;
    }

    /**
     * Get friends
     *
     * @return array
     */
    public function getFriends()
    {
        return $this->friends;
    }

    public function addFriend($id_new_friend)
    {
        array_push($this->friends, $id_new_friend);

        $this->setFriends($this->friends);

        return $this;
    }

    public function eraseCredentials()
    {
    }

    /**
     * Add notifications
     *
     * @param \SB\Bundle\NotificationBundle\Entity\Notification $notifications
     * @return User
     */
    public function addNotification(Notification $notifications)
    {
        $this->notifications[] = $notifications;

        return $this;
    }

    /**
     * Remove notifications
     *
     * @param \SB\Bundle\NotificationBundle\Entity\Notification $notifications
     */
    public function removeNotification(Notification $notifications)
    {
        $this->notifications->removeElement($notifications);
    }

    /**
     * Get notifications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set pays
     *
     * @param string $pays
     *
     * @return User
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set region
     *
     * @param string $region
     *
     * @return User
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return User
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set confidentiality
     *
     * @param \SB\Bundle\UserBundle\Entity\Confidentiality $confidentiality
     *
     * @return User
     */
    public function setConfidentiality(Confidentiality $confidentiality)
    {
        $this->confidentiality = $confidentiality;

        return $this;
    }

    /**
     * Get confidentiality
     *
     * @return \SB\Bundle\UserBundle\Entity\Confidentiality
     */
    public function getConfidentiality()
    {
        return $this->confidentiality;
    }

    /**
     * Set avatar
     *
     * @param \SB\Bundle\UserBundle\Entity\Avatar $avatar
     *
     * @return User
     */
    public function setAvatar(Avatar $avatar = null)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return \SB\Bundle\UserBundle\Entity\Avatar
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set cover
     *
     * @param \SB\Bundle\UserBundle\Entity\Cover $cover
     *
     * @return User
     */
    public function setCover(Cover $cover = null)
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * Get cover
     *
     * @return \SB\Bundle\UserBundle\Entity\Cover
     */
    public function getCover()
    {
        return $this->cover;
    }
}
