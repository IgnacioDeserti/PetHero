<?php

namespace Controllers;

use DAO\guardiansDAO;
use DAO\ownersDAO;
use DAO\petDAO;
use Models\Pet;
use DAO\sizeDAO;
use DAO\guardian_x_sizeDAO;
use DAO\ReviewDAO;

class OwnerController
{

    private $ownerDAO;
    private $guardianDAO;
    private $PetDAO;
    private $sizeDAO;
    private $guardian_x_sizeDAO;
    private $reviewDAO;

    public function __construct()
    {
        $this->guardianDAO = new guardiansDAO();
        $this->ownerDAO = new ownersDAO();
        $this->PetDAO = new petDAO();
        $this->sizeDAO = new sizeDAO();
        $this->guardian_x_sizeDAO = new guardian_x_sizeDAO();
        $this->reviewDAO = new ReviewDAO();
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
        $arrayListSize = $this->sizeDAO->getAll();
        $arrayListGuardianxSize = $this->guardian_x_sizeDAO->getAll();


        require_once(VIEWS_PATH . "validate-session.php");
        require_once(VIEWS_PATH . "listGuardian.php");
    }

    public function addPet($name, $type, $breed, $size, $observations, $files){
        $this->PetDAO->getAll();

        $newPet = new Pet();
        $newPet->setName($name);
        $newPet->setType($type);
        $newPet->setBreed($breed);
        $newPet->setIdSize($size);
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
        $arrayListPet = $this->PetDAO->GetPetByIdOwner($_SESSION["idUser"]);
        $sizeList = $this->sizeDAO->getAll();
        require_once(VIEWS_PATH . "validate-session.php");
        require_once(VIEWS_PATH . "listPet.php");
    }

    public function showAddPet()
    {
        require_once(VIEWS_PATH . "validate-session.php");
        require_once(VIEWS_PATH . "addPet.php");
    }

    public function selectGuardian($email){
        $guardian = $this->guardianDAO->getGuardian($email);
        $arrayListSize = $this->sizeDAO->getAll();
        $arrayListGuardianxSize = $this->guardian_x_sizeDAO->getAll();
        $reviewsList = $this->reviewDAO->GetReviewsByGuardian($guardian->getIdGuardian());
        $ownerList = $this->ownerDAO;
        require_once(VIEWS_PATH . "validate-session.php");
        require_once(VIEWS_PATH . "showGuardian.php");
    }

    public function selectPet($button, $email){
        if(strcmp($button, "goBack") == 0){
            $this->showGuardianList();
        }else{
            $guardian = $this->guardianDAO->getGuardian($email);
            $sizeList = $this->sizeDAO->getAll();
            $arrayListGuardianxSize = $this->guardian_x_sizeDAO->getAll();
            $arrayListPetUser = $this->PetDAO->GetPetByIdOwner($_SESSION["idUser"]);
            $arrayListPet = array();

            foreach($arrayListPetUser as $pet){
                foreach($arrayListGuardianxSize as $gxs){
                    if($guardian->getIdGuardian() == $gxs->getIdGuardian()){
                        if($gxs->getIdSize() == $pet->getIdSize()){
                            array_push($arrayListPet, $pet);
                        }
                    }
                }
            }

            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "createReservationOwner.php");
        }
    }

    public function createReservationOwner(){

    }

}
