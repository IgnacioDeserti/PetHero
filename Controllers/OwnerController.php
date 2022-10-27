<?php

namespace Controllers;

use DAO\guardiansDAO as GuardianDAO;
use DAO\guardiansDAO;
use DAO\ownersDAO;
use DAO\petDAO;
use Models\Pet;

class OwnerController
{

    private $ownerDAO;
    private $guardianDAO;
    private $PetDAO;

    public function __construct()
    {
        $this->guardianDAO = new guardiansDAO();
        $this->ownerDAO = new ownersDAO();
        $this->PetDAO = new petDAO();
    }


    public function menuOwner($button)
    {
        if ($button == "listGuardian") {
            require_once(VIEWS_PATH . "validate-session.php");
            $this->showGuardianList();
        } else if ($button == "addPet") {
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "addPet.php");
        } else if ($button == "listPet") {
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "listPet.php");
        }
    }

    public function showGuardianList($availabilityStart = null,$availabilityEnd = null){

        if(!isset($availabilityStart) && !isset($availabilityEnd)){
            $availabilityStart = date("1990-01-01");
            $availabilityEnd = date("3000-12-31");
        }
        $arrayListGuardian = $this->guardianDAO->getAll();
        require_once(VIEWS_PATH . "validate-session.php");
        require_once(VIEWS_PATH . "listGuardian.php");
    }

    public function addPet($name, $breed, $size, $observations, $files){
        $this->PetDAO->getAll();

        $newPet = new Pet();
        $newPet->setName($name);
        $newPet->setBreed($breed);
        $newPet->setSize($size);
        $newPet->setObservations($observations);
        $newPet->setIdOwner($_SESSION["idUser"]);
        
        $fileController = new FileController();
        
        if($pathFile1 = $fileController->upload($files["photo1"], "Foto-Perfil")){
            $newPet->setPhoto1($pathFile1);
        }

        if($pathFile2 = $fileController->upload($files["photo2"], "Foto-Vacunacion")){
            $newPet->setPhoto2($pathFile2);
        }

        if($files["video"]){
            if($pathFile3 = $fileController->upload($files["video"], "Video")){
                $newPet->setVideo($pathFile3);
            }
        }

        $this->PetDAO->add($newPet);

        $this->showListPet();
    }

    public function showListPet()
    {   
        $arrayListPet = $this->PetDAO->getAll();
        require_once(VIEWS_PATH . "validate-session.php");
        require_once(VIEWS_PATH . "listPet.php");
    }

    public function showAddPet()
    {
        require_once(VIEWS_PATH . "validate-session.php");
        require_once(VIEWS_PATH . "addPet.php");
    }

}
