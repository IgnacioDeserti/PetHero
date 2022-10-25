<?php

namespace Controllers;

use DAO\guardiansDAO as GuardianDAO;
use DAO\guardiansDAO;
use DAO\ownersDAO;
use DAO\dogDAO;
use Models\Dog;

class OwnerController
{

    private $ownerDAO;
    private $guardianDAO;
    private $dogDAO;

    public function __construct()
    {
        $this->guardianDAO = new guardiansDAO();
        $this->ownerDAO = new ownersDAO();
        $this->dogDAO = new dogDAO();
    }


    public function menuOwner($button)
    {
        if ($button == "listGuardian") {
            require_once(VIEWS_PATH . "validate-session.php");
            $this->showGuardianList();
        } else if ($button == "addDog") {
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "addDog.php");
        } else if ($button == "listDog") {
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "listDog.php");
        }
    }

    public function showGuardianList(){
        $arrayListGuardian = $this->guardianDAO->getAll();
        require_once(VIEWS_PATH . "listGuardian.php");
    }

    public function addDog($name, $breed, $size, $observations, $files){
        $this->dogDAO->getAll();

        $newDog = new Dog();
        $newDog->setName($name);
        $newDog->setBreed($breed);
        $newDog->setSize($size);
        $newDog->setObservations($observations);
        $newDog->setIdOwner($_SESSION["idUser"]);
        
        $fileController = new FileController();
        
        if($pathFile1 = $fileController->upload($files["photo1"], "Foto-Perfil")){
            $newDog->setPhoto1($pathFile1);
        }

        if($pathFile2 = $fileController->upload($files["photo2"], "Foto-Vacunacion")){
            $newDog->setPhoto2($pathFile2);
        }

        if($files["video"]){
            if($pathFile3 = $fileController->upload($files["video"], "Video")){
                $newDog->setVideo($pathFile3);
            }
        }

        $this->dogDAO->add($newDog);

        $this->showListDog();
    }

    public function showListDog()
    {
        $arrayListDog = $this->dogDAO->getAll();
        require_once(VIEWS_PATH . "validate-session.php");
        require_once(VIEWS_PATH . "listDog.php");
    }

    public function showAddDog()
    {
        require_once(VIEWS_PATH . "validate-session.php");
        require_once(VIEWS_PATH . "addDog.php");
    }

}
