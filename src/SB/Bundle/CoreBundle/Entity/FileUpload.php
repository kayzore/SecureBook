<?php

namespace SB\Bundle\CoreBundle\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUpload
{
    /**
     * @var UploadedFile
     */
    private $file;
    /**
     * @var string
     */
    private $username;


    public function __construct(UploadedFile $file, $username)
    {
        $this->file = $file;
        $this->username = $username;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    public function upload()
    {
        // On récupère le nom original du fichier de l'internaute
        $name = md5(uniqid() . $this->username . $this->file->getClientOriginalName()) . '.' . $this->file->getClientOriginalExtension();

        // On déplace le fichier envoyé dans le répertoire de notre choix
        $this->file->move($this->getUploadRootDir(), $name);

        // On retourne le nom de fichier
        return $name;
    }

    public function getUploadDir()
    {
        // On retourne le chemin relatif vers l'image pour un navigateur (relatif au répertoire /web donc)
        return 'uploads/img';
    }

    protected function getUploadRootDir()
    {
        // On retourne le chemin relatif vers l'image pour notre code PHP
        return __DIR__.'/../../../../../web/'.$this->getUploadDir();
    }
}
