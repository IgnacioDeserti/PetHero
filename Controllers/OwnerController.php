<?php

namespace Controllers;

use DAO\guardiansDAO;
use DAO\ownersDAO;
use DAO\petDAO;
use Models\Pet;
use DAO\sizeDAO;
use DAO\guardian_x_sizeDAO;
use DAO\ReviewDAO;
use DAO\ReservationDAO;

class OwnerController
{

    private $ownerDAO;
    private $guardianDAO;
    private $PetDAO;
    private $sizeDAO;
    private $guardian_x_sizeDAO;
    private $reviewDAO;
    private $reservationDAO;

    public function __construct()
    {
        $this->guardianDAO = new guardiansDAO();
        $this->ownerDAO = new ownersDAO();
        $this->PetDAO = new petDAO();
        $this->sizeDAO = new sizeDAO();
        $this->guardian_x_sizeDAO = new guardian_x_sizeDAO();
        $this->reviewDAO = new ReviewDAO();
        $this->reservationDAO = new ReservationDAO();
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
        $gxsDAO = $this->guardian_x_sizeDAO;

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

        $this->PetDAO->add($newPet);

        echo "<pre>";
        print_r($files);
        
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

        //$this->showListPet();
    }

    public function showListPet()
    {   
        $arrayListPet = $this->PetDAO->GetPetByIdOwner($_SESSION["idUser"]);
        $size = $this->sizeDAO;
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

    /*public function selectPet($button, $email){
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
    }*/

    //TODO: filtrado guardian por raza
    //TODO: hacer reservas

    public function getDisponibily ($idGuardian){
        
        $listReservationsGuardian = $this->reservationDAO->GetReservationDates($idGuardian);
        $start=0;
        $end=1;
        $breed=2;
        $listAvailability = array();
        $startAv = null;
        $endAv = null;
        $breedAv = 'all';
        $date = $startAv;


        while($date<=$this->guardianDAO->getReservationEnd($idGuardian)){
            if(count($listReservationsGuardian)>=3 && $listReservationsGuardian[$start] == $date){
                if($startAv != null && $endAv != null){
                    array_push($listAvailability,$startAv);
                    array_push($listAvailability,$endAv);
                    array_push($listAvailability,$breedAv);
                       
                }
                $startAv = $listReservationsGuardian[$start];
                $endAv = $listReservationsGuardian[$end];
                $breedAv = $listReservationsGuardian[$breed];
                $date = strtotime("+1 day", $endAv);
                if(($breed + 3) < count($listReservationsGuardian)){
                    $start = $start + 3;
                    $end = $end + 3;
                    $breed = $breed + 3;
                }
                array_push($listAvailability,$startAv);
                array_push($listAvailability,$endAv);
                array_push($listAvailability,$breedAv);
                $startAv = null;
                $endAv = null;
                $breedAv = 'all';
            }
            else if ($startAv == null && $endAv == null){
                $startAv=$date;
                $endAv=$date;
                $date = strtotime("+1 day", $date);
            }
            else if($endAv != null){
                $endAv=$date;
                $date = strtotime("+1 day", $date);
            }
            if($date == $this->guardianDAO->getReservationEnd($idGuardian)){
                array_push($listAvailability,$startAv);
                array_push($listAvailability,$endAv);
                array_push($listAvailability,$breed);
            }
        }
        
        return $listAvailability;
    }

}
