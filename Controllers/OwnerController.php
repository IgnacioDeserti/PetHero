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
use Exception;
use Models\Reservation;

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


    //permite mandar los parametros para filtrar guardianes
    public function filterGuardians(){
        $listPets = $this->PetDAO->GetPetByIdOwner($_SESSION["idUser"]);
        require_once(VIEWS_PATH . "validate-session.php");
        require_once(VIEWS_PATH . "filterGuardianList.php");
    }

    //llama al checkeo 
    public function showGuardianList($availabilityStart ,$availabilityEnd, $idPet){
        $listGuardian = $this->guardianDAO->getAll();
        $listGuardianSize = array();
        $pet = $this->PetDAO->getPetByIdPet($idPet);
        foreach($listGuardian as $guardian){
            $listSize = $this->guardian_x_sizeDAO->getSizeById($guardian->getSize());
            foreach($listSize as $size){
                if(strcmp($this->sizeDAO->getName($pet->getIdSize()),$size) == 0){
                    array_push($listGuardianSize,$guardian);
                }
            }
        }
        $listChecked = array();
        
        $i = 0;
        foreach($listGuardianSize as $guardian){
            if($this->checkGuardian($availabilityStart ,$availabilityEnd, $pet->getBreed(), $pet->getType(), $this->sizeDAO->getName($pet->getIdSize()), $guardian->getIdGuardian())){
                array_push($listChecked,$guardian);
            }
        }
        $gxsDAO = $this->guardian_x_sizeDAO;
        require_once(VIEWS_PATH . "validate-session.php");
        require_once(VIEWS_PATH . "listGuardian.php");
    }

    //checkea que la disponibilidad deseada este dentro de la disponibilidad del guardian
    public function checkGuardian($availabilityStart ,$availabilityEnd, $breed, $type, $size, $idGuardian){
        $flag = 0;
        $listDisponibility = $this->getDisponibilityByGuardian($idGuardian);
        $guardian = $this->guardianDAO->getGuardianById($idGuardian);

        $i = 0;
        while($i<count($listDisponibility)){
            
            if(($availabilityStart>=$guardian->getAvailabilityStart()) && ($availabilityStart<=$listDisponibility[$i+1]) && ($availabilityEnd<=$listDisponibility[$i+1]) && ((strcmp($listDisponibility[$i+2],$breed) == 0) || ((strcmp($listDisponibility[$i+2],'all') == 0))) && ((strcmp($listDisponibility[$i+3],$type) == 0) || ((strcmp($listDisponibility[$i+3],'all') == 0))) && ((strcmp($listDisponibility[$i+4],$size) == 0) || (strcmp($listDisponibility[$i+4],'all') == 0))){
                $flag=1;
            }
            else if(($availabilityStart>=$listDisponibility[$i]) && ($availabilityStart<=$listDisponibility[$i+1]) && ($availabilityEnd<=$listDisponibility[$i+1]) && ((strcmp($listDisponibility[$i+2],$breed) == 0) || ((strcmp($listDisponibility[$i+2],'all') == 0))) && ((strcmp($listDisponibility[$i+3],$type) == 0) || ((strcmp($listDisponibility[$i+3],'all') == 0))) && ((strcmp($listDisponibility[$i+4],$size) == 0) || (strcmp($listDisponibility[$i+4],'all') == 0))){
                $flag=1;
            }
            else if(($availabilityStart>=$listDisponibility[$i]) && ($availabilityStart<=$listDisponibility[$i+1]) && ($availabilityEnd>$listDisponibility[$i+1]) && ((strcmp($listDisponibility[$i+2],$breed) == 0) || ((strcmp($listDisponibility[$i+2],'all')) == 0)) && ((strcmp($listDisponibility[$i+3],$type) == 0) || ((strcmp($listDisponibility[$i+3],'all') == 0))) && ((strcmp($listDisponibility[$i+4],$size) == 0) || (strcmp($listDisponibility[$i+4],'all') == 0))){
                $flag=2;
                $i = $i+5;
            }
            if($flag==2){
                if(($availabilityStart<$listDisponibility[$i]) && ($availabilityEnd<=$listDisponibility[$i+1]) && ((strcmp($listDisponibility[$i+2],$breed) == 0) || ((strcmp($listDisponibility[$i+2],'all') == 0))) && ((strcmp($listDisponibility[$i+3],$type) == 0) || ((strcmp($listDisponibility[$i+3],'all') == 0))) && ((strcmp($listDisponibility[$i+4],$size) == 0) || (strcmp($listDisponibility[$i+4],'all') == 0))){
                    $flag=1;
                }
                else if(($availabilityStart<$listDisponibility[$i]) && ($availabilityEnd<=$listDisponibility[$i+1]) && (!(strcmp($listDisponibility[$i+2],$breed) == 0) && (!(strcmp($listDisponibility[$i+2],'all') == 0))) && (!(strcmp($listDisponibility[$i+3],$type)== 0) && (!(strcmp($listDisponibility[$i+3],'all') == 0))) && (!(strcmp($listDisponibility[$i+4],$size) == 0) && !(strcmp($listDisponibility[$i+4],'all') == 0))){
                    $flag=0;
                }
            }
            if((($i+4)==(count($listDisponibility)-1)) && ($flag==2)){
                $flag=0;
            }
            $i = $i+5;
        }

        return $flag;
    }


    public function typePet($type = null){
        if(isset($type)){
            if(strcmp($type, "D") == 0){
                require_once(VIEWS_PATH . "validate-session.php");
                require_once(VIEWS_PATH . "addDog.php");
            }else{
                require_once(VIEWS_PATH . "validate-session.php");
                require_once(VIEWS_PATH . "addCat.php");
            }
        }else{
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "addPet.php");
        }
    }

    public function addPet($name, $breed, $size, $observations, $type, $files){
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
        $formato = 'Y-m-d';
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

                if(count($listAvailability)>=5 && (strcmp($listAvailability[(count($listAvailability))-3],$listReservationsGuardian[$breed])==0) && (($listAvailability[(count($listAvailability)-4)])<=$listReservationsGuardian[$start]) && (((strcmp($listAvailability[(count($listAvailability))-2],$listReservationsGuardian[$type])==0))) && (strcmp($listAvailability[(count($listAvailability))-1],$listReservationsGuardian[$size])==0)){
                    $listAvailability[(count($listAvailability))-4]=$listReservationsGuardian[$end]; 
                    if(($size + 5) < count($listReservationsGuardian)){
                        $start = $start + 5;
                        $end = $end + 5;
                        $breed = $breed + 5;
                        $type = $type + 5;
                        $size = $size + 5;
                        $startAv = null;
                        $endAv = null;
                        $breedAv = 'all';
                        $typeAv = 'all';
                        $sizeAv = 'all';
                    }else{
                        $date = strtotime($date);
                        $date= strtotime("+1 day",$date);
                        $date = date($formato,$date);
                    }
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
                    else{
                        $date = strtotime($date);
                        $date= strtotime("+1 day",$date);
                        $date = date($formato,$date);
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
                    $date = strtotime($date);
                    $date = strtotime('+1 day',$date);
                    $date = date($formato,$date);
                }
            }
            else if(count($listAvailability) > 0 && $listAvailability[(count($listAvailability)-5)] <= $date && $date <=$listAvailability[(count($listAvailability)-4)]){
                $date = strtotime($listAvailability[count($listAvailability) - 4]);
                $date = strtotime('+1 day',$date);
                $date = date($formato,$date);
            }
            else if ($startAv == null && $endAv == null){
                $startAv=$date;
                $endAv=$date;
                $date = strtotime($date);
                $date = strtotime('+1 day',$date);
                $date = date($formato,$date);
            }
            else if($endAv != null){
                $endAv=$date;
                $date = strtotime($date);
                $date = strtotime('+1 day',$date);
                $date = date($formato,$date);
            }
            if($date > $this->guardianDAO->getReservationEnd($idGuardian)){
                array_push($listAvailability,$startAv);
                array_push($listAvailability,$endAv);
                array_push($listAvailability,$breedAv);
                array_push($listAvailability,$typeAv);
                array_push($listAvailability,$sizeAv);
            }
        }
        
        return $listAvailability;
    }

    public function createReservation($idGuardian){
        $petList = $this->PetDAO->GetPetByIdOwner($_SESSION["idUser"]);
        $sizesGuardian = $this->guardian_x_sizeDAO->getSizeById($idGuardian);
        $petChecked = array();  
        foreach($petList as $pet){
            foreach($sizesGuardian as $size){
                if(strcmp($this->sizeDAO->getName($pet->getIdSize()),$size) == 0){
                    array_push($petChecked,$pet);
                }
            }
        }

        require_once(VIEWS_PATH . "validate-session.php");
        require_once(VIEWS_PATH . "createReservationOwner.php");
    }

    public function makeReservation($availabilityStart, $availabilityEnd, $idPet, $idGuardian){
            $pet = $this->PetDAO->GetPetByIdPet($idPet);
            $guardian = $this->guardianDAO->getGuardianById($idGuardian);
            try{
                if($this->checkReservationDate($availabilityStart, $availabilityEnd, $idPet, $idGuardian)){
                    
                    $reservation = new Reservation();
                    $reservation->setIdOwner($_SESSION['idUser']);
                    $reservation->setIdGuardian($idGuardian);
                    $reservation->setIdPet($idPet);
                    $reservation->setBreed($pet->getBreed());
                    $reservation->setAnimalType($pet->getType());
                    $reservation->setReservationDateStart($availabilityStart);
                    $reservation->setReservationDateEnd($availabilityEnd);
                    $reservation->setSize($this->sizeDAO->getName($pet->getIdSize()));
                    $reservation->setPrice($this->totalPrice($guardian->getPrice(), $availabilityStart, $availabilityEnd));
                    $this->reservationDAO->Add($reservation);
                    $this->showReservationsList();
                }

            }catch (Exception $e){
                $this->createReservation($idGuardian);
            }
    }

    public function showReservationsList(){
        $wcReservationList = $this->reservationDAO->getReservationByStatusAndIdOwner("Esperando confirmacion", $_SESSION['idUser']);
        $fReservationList = $this->reservationDAO->getReservationByStatusAndIdOwner("Finalizado", $_SESSION['idUser']);
        $cReservationList = $this->reservationDAO->getReservationByStatusAndIdOwner("Aceptada", $_SESSION['idUser']);
        $allpets = $this->PetDAO;
        $guardian = $this->guardianDAO;
        $owner =$this->ownerDAO;
        
        require_once(VIEWS_PATH . "validate-session.php");
        require_once(VIEWS_PATH . "listReservationOwner.php");
    }

    private function totalPrice($pricePD, $availabilityStart, $availabilityEnd){
        $date = $availabilityStart;
        $formato = 'Y-m-d';
        $i = 0;
        while($date <= $availabilityEnd){
            $date = strtotime($date);
            $date = strtotime('+1 day',$date);
            $date = date($formato,$date);
            $i++;
        }

        return ($i * $pricePD);
    }

    private function checkReservationDate($availabilityStart, $availabilityEnd, $idPet, $idGuardian){
        $pet = $this->PetDAO->getPetByIdPet($idPet);
        $listDisponibility = $this->getDisponibilityByGuardian($idGuardian);
        $flag = 0;
        $i = 0;
        if($availabilityStart<$this->guardianDAO->getReservationStart($idGuardian) || $availabilityEnd>$this->guardianDAO->getReservationEnd($idGuardian)){
            throw new Exception ('Fechas invalidas');
        }
        while($i<count($listDisponibility)){
            if(($availabilityStart>=$listDisponibility[$i]) && ($availabilityEnd<=$listDisponibility[$i+1]) && ($availabilityEnd<=$listDisponibility[$i+1]) && ((strcmp($listDisponibility[$i+2],$pet->getBreed())) || ((strcmp($listDisponibility[$i+2],'all')))) && ((strcmp($listDisponibility[$i+3],$pet->getType())) || ((strcmp($listDisponibility[$i+3],'all')))) && ((strcmp($listDisponibility[$i+4],$this->sizeDAO->getName($pet->getIdSize()))) || (strcmp($listDisponibility[$i+4],'all')))){
                $flag=1;
            }
            else if(($availabilityStart>=$listDisponibility[$i]) && ($availabilityStart<=$listDisponibility[$i=1]) && ($availabilityEnd>$listDisponibility[$i+1]) && ((strcmp($listDisponibility[$i+2],$pet->getBreed())) || ((strcmp($listDisponibility[$i+2],'all')))) && ((strcmp($listDisponibility[$i+3],$pet->getType())) || ((strcmp($listDisponibility[$i+3],'all')))) && ((strcmp($listDisponibility[$i+4],$this->sizeDAO->getName($pet->getIdSize()))) || (strcmp($listDisponibility[$i+4],'all')))){
                $flag=2;
            }
            if($flag==2){
                if(($availabilityStart<$listDisponibility[$i]) && ($availabilityEnd<=$listDisponibility[$i+1]) && ((strcmp($listDisponibility[$i+2],$pet->getBreed())) || ((strcmp($listDisponibility[$i+2],'all')))) && ((strcmp($listDisponibility[$i+3],$pet->getType())) || ((strcmp($listDisponibility[$i+3],'all')))) && ((strcmp($listDisponibility[$i+4],$this->sizeDAO->getName($pet->getIdSize()))) || (strcmp($listDisponibility[$i+4],'all')))){
                    $flag=1;
                }
                else if(($availabilityStart<$listDisponibility[$i]) && ($availabilityEnd<=$listDisponibility[$i+1]) && (!(strcmp($listDisponibility[$i+2],$pet->getBreed())) && (!(strcmp($listDisponibility[$i+2],'all')))) && (!(strcmp($listDisponibility[$i+3],$pet->getType())) && (!(strcmp($listDisponibility[$i+3],'all')))) && (!(strcmp($listDisponibility[$i+4],$this->sizeDAO->getName($pet->getIdSize()))) && !(strcmp($listDisponibility[$i+4],'all')))){
                    $flag=0;
                }
            }
            if(($i+4)==(count($listDisponibility)-1) && $flag==2){
                $flag=0;
            }
            $i= $i +5;
        }
        if($flag==0){
            throw new Exception ('Fechas invalidas');
        }
        return $flag;
    }

}


