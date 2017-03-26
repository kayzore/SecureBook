<?php

namespace SB\Bundle\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SB\Bundle\CoreBundle\Entity\FileUpload;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Cover
 *
 * @ORM\Table(name="cover")
 * @ORM\Entity(repositoryClass="SB\Bundle\UserBundle\Repository\CoverRepository")
 */
class Cover
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true, unique=true)
     */
    private $name;

    /**
     * @var UploadedFile
     */
    private $file;

    /**
     * @var string
     */
    private $path;


    public function __construct($path)
    {
        $this->path = $path;
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
     * Set name
     *
     * @param string $name
     *
     * @return Cover
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param UploadedFile|null $file
     * @return Cover
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;

        return $this;
    }

    public function upload($username)
    {
        $fileUpload = new FileUpload($this->file, $username, $this->path);
        $this->name = $fileUpload->upload();
    }

    public function __sleep()
    {
        $ref   = new \ReflectionClass(__CLASS__);
        $props = $ref->getProperties(\ReflectionProperty::IS_PROTECTED);

        $serialize_fields = array();

        foreach ($props as $prop) {
            $serialize_fields[] = $prop->name;
        }

        return $serialize_fields;
    }
}

