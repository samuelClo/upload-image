<?php
namespace App\Models;


class FileUploader
{
    public $imagePath;
    public $loader;
    public $imageSize;
    public $twig;
    public $storeName;
    public $imageName;
    private $errorMessage;
    public $imageExtension;

    public function __construct()
    {
        $this->imageExtension = $_FILES['userfile']['name'];
        $this->imageSize = $_FILES['userfile']['size'];
        $this->imageName =  $_POST['filename'];
        $this->imagePath = "image/" . $this->imageName . '.' . $this->getFileExtension();

        $this->loader = $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates');
        $this->twig = $twig = new \Twig\Environment($loader,['cache' => false]);
    }

    public function setFileData ()
    {
        if (empty(trim($_POST['filename'])))
        {
            $this->errorMessage = 'Le nom de l\'image est obligatoire';
        }
        else
        {
            if ($_FILES['userfile']['error'] === 0)
            {
                $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');

                if (in_array($this->getFileExtension(), $allowed_extensions))
                {
                    if ($this->imageSize < 1048576)
                    {
                        if (!file_exists("image/". $this->imageName . "." . $this->getFileExtension()))
                        {
                            return;
                        }
                        $this->errorMessage = 'l\'image '. $this->imageName . "." . $this->getFileExtension() . ' existe déja';
                    }
                    else
                    {
                        $this->errorMessage = 'Le poid de l\'image est trop volumineux';
                    }
                }
                else
                {
                    $this->errorMessage = 'Ce type de fichier n\'est pas autorisé';
                }
            }
            else
            {
                $this->errorMessage = 'L\'image est obligatoire';
            }
        }

        if ($this->errorMessage)
            echo $this->twig->render('index.html.twig', ['error' => $this->errorMessage]);
    }
    
    public function getFileExtension()
    {
        return pathinfo($this->imageExtension, PATHINFO_EXTENSION);
    }

    public function upload()
    {
        $destination = '../../image/'.$this->storeName;
        move_uploaded_file($_FILES['userfile']['tmp_name'], $destination);
        if ( file_exists ( '../../image/'.$this->storeName))
            echo $this->twig->render('index.html.twig', ['success' => 'Votre image a été enregistré']);
    }

    public function setStoreName()
    {
        $this->storeName = $this->imageName . '.' . $this->getFileExtension();;
    }
};