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
            $this->filterGuardians();
        } else if ($button == "addPet") {
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "addPet.php");
        } else if ($button == "listPet") {
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "listPet.php");
        }
    }

    public function filterGuardians(){
        $listPets = $this->PetDAO->GetPetByIdOwner($_SESSION["idUser"]);
        require_once(VIEWS_PATH . "validate-session.php");
        require_once(VIEWS_PATH . "filterGuardianList.php");
    }

    public function showGuardianList($availabilityStart ,$availabilityEnd, $breed, $type, $size){
        $listGuardian = $this->guardianDAO->getAll();
        $listChecked = array();
        foreach($listGuardian as $guardian){
            if ($this->checkGuardian($availabilityStart ,$availabilityEnd, $breed, $type, $size, $guardian->getIdGuardian())){
                array_push($listChecked,$guardian);
            }
        }
        require_once(VIEWS_PATH . "validate-session.php");
        require_once(VIEWS_PATH . "listGuardian.php");
       
    }

    public function checkGuardian($availabilityStart ,$availabilityEnd, $breed, $type, $size , $idGuardian){
        $flag = 0;
        $listDisponibility = $this->getDisponibilityByGuardian($idGuardian);

        for($i=0; $i<count($listDisponibility);$i+5){
            if(($availabilityStart>=$listDisponibility[$i]) && ($availabilityEnd<=$listDisponibility[$i+1]) && (strcmp($listDisponibility[$i+2],$breed)) && (strcmp($listDisponibility[$i+3],$type)) && ((strcmp($listDisponibility[$i+4],$size)) || (strcmp($listDisponibility[$i+4],'all')))){
                $flag=1;
            }
        }
        return $flag;
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

    public function getDisponibilityByGuardian ($idGuardian){
        
        $listReservationsGuardian = $this->reservationDAO->GetReservationDates($idGuardian);
        $start=0;
        $end=1;
        $breed=2;
        $type= 3;
        $size = 4;
        $listAvailability = array();
        $startAv = null;
        $endAv = null;
        $breedAv = 'all';
        $typeAv = 'all';
        $sizeAv = 'all';
        $date = $this->guardianDAO->getReservationStart($idGuardian);


        while($date<=$this->guardianDAO->getReservationEnd($idGuardian)){

            if(count($listReservationsGuardian)>=5 && $listReservationsGuardian[$start] == $date){
                if($startAv != null && $endAv != null){
                    array_push($listAvailability,$startAv);
                    array_push($listAvailability,$endAv);
                    array_push($listAvailability,$breedAv);
                    array_push($listAvailability,$typeAv);
                    array_push($listAvailability,$sizeAv);
                }
                if(count($listAvailability)>=5 && strcmp($listAvailability[(count($listAvailability))-3],$listReservationsGuardian[$breed]) && (($listAvailability[(count($listAvailability)-4)])+1)>=$listReservationsGuardian[$start] && strcmp($listAvailability[(count($listAvailability))-2],$listReservationsGuardian[$type]) && strcmp($listAvailability[(count($listAvailability))-1],$listReservationsGuardian[$size])){
                    $listAvailability[(count($listAvailability))-4]=$listReservationsGuardian[$end];
                }
                else {
                    $startAv = $listReservationsGuardian[$start];
                    $endAv = $listReservationsGuardian[$end];
                    $breedAv = $listReservationsGuardian[$breed];
                    $typeAv = $listReservationsGuardian[$type];
                    $sizeAv = $listReservationsGuardian[$size];
                    if(($size + 5) < count($listReservationsGuardian)){
                        $start = $start + 5;
                        $end = $end + 5;
                        $breed = $breed + 5;
                        $type = $type + 5;
                        $size = $size + 5;
                    }
                    array_push($listAvailability,$startAv);
                    array_push($listAvailability,$endAv);
                    array_push($listAvailability,$breedAv);
                    array_push($listAvailability,$typeAv);
                    array_push($listAvailability,$sizeAv);
                    $startAv = null;
                    $endAv = null;
                    $breedAv = 'all';
                    $typeAv = 'all';
                    $sizeAv = 'all';
                }
                if($listReservationsGuardian[$start]!=$date){
                    $date = strtotime("+1 day", $date);
                }
            }
            else if($listAvailability[(count($listAvailability))-3]<$date<=$listAvailability[(count($listAvailability)-2)]){
                $date = strtotime("+1 day", $date);
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
                array_push($listAvailability,$breedAv);
                array_push($listAvailability,$typeAv);
                array_push($listAvailability,$sizeAv);
            }
        }
        
        return $listAvailability;
    }

}


