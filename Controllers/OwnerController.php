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
    use DAO\PaymentCouponDAO; 
    use Models\PaymentCoupon;

    class OwnerController
    {

        private $ownerDAO;
        private $guardianDAO;
        private $PetDAO;
        private $sizeDAO;
        private $guardian_x_sizeDAO;
        private $reviewDAO;
        private $reservationDAO;
        private $paymentDAO;

        public function __construct()
        {
            $this->guardianDAO = new guardiansDAO();
            $this->ownerDAO = new ownersDAO();
            $this->PetDAO = new petDAO();
            $this->sizeDAO = new sizeDAO();
            $this->guardian_x_sizeDAO = new guardian_x_sizeDAO();
            $this->reviewDAO = new ReviewDAO();
            $this->reservationDAO = new ReservationDAO();
            $this->paymentDAO = new PaymentCouponDAO();
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
                $listSize = $this->guardian_x_sizeDAO->getSizeById($guardian->getIdGuardian());
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
                if(($availabilityStart>=$listDisponibility[$i]) && ($availabilityEnd<=$listDisponibility[$i+1]) && ((strcmp($listDisponibility[$i+2],$breed) == 0) || (strcmp($listDisponibility[$i+2],'all') == 0)) && ((strcmp($listDisponibility[$i+3],$type) == 0) || (strcmp($listDisponibility[$i+3],'all') == 0)) && ((strcmp($listDisponibility[$i+4],$size) == 0) || (strcmp($listDisponibility[$i+4],'all') == 0))){
                    $flag = 1;
                }
                $i=$i+5;
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

        public function selectGuardian($availabilityStart, $availabilityEnd, $idPet, $email){
            $guardian = $this->guardianDAO->getGuardian($email);
            $arrayListSize = $this->sizeDAO->getAll();
            $arrayListGuardianxSize = $this->guardian_x_sizeDAO->getAll();
            $reviewsList = $this->reviewDAO->GetReviewsByGuardian($guardian->getIdGuardian());
            $ownerList = $this->ownerDAO;
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "showGuardian.php");
        }

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

        public function makeReservation($availabilityStart, $availabilityEnd, $idPet, $idGuardian){
                $pet = $this->PetDAO->GetPetByIdPet($idPet);
                $guardian = $this->guardianDAO->getGuardianById($idGuardian);
                try{
                    if($this->checkGuardian($availabilityStart, $availabilityEnd, $pet->getBreed(), $pet->getType(), $this->sizeDAO->getName($pet->getIdSize()), $idGuardian)){
                        
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
                    $this->filterGuardians();
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

        public function chargeCard($idReservation){
            require_once(VIEWS_PATH . 'validate-session.php');
            require_once(VIEWS_PATH . 'chargeCard.php');
        }

        public function chargePayment ($cardNumber, $titular ,$expirationMonth, $expirationYear,$secCode,$idReservation){
            date_default_timezone_set("America/Buenos_Aires");
            $date = strtotime('today');
            try{   
                $this->checkExpirationDate($expirationMonth,$expirationYear,$date);
                $this->createPayment($idReservation, $titular,$date);
            }catch (Exception $e){
                $alert = [];
                $this->chargeCard($idReservation);
            } 
        }

        public function createPayment($titular,$date,$idReservation){
            $payment = new PaymentCoupon();
            $reservation = $this->reservationDAO->GetReservationsById($idReservation);
            $payment->setOwnerName($this->ownerDAO->GetNameById($reservation->getIdOwner()));
            $payment->setGuardianName(($this->guardianDAO->getGuardianById($reservation->getIdGuardian()))->getName());
            $payment->setPetName(($this->PetDAO->getPetByIdPet($reservation->getIdPet()))->getName());
            $payment->setPrice($reservation->getPrice()/2);
            $payment->setDate($date);
            $payment->setTitular($titular);
            $payment->setReservationNumber($reservation->getIdReservation());
            $this->paymentDAO->Add($payment);
            $this->getCoupon($idReservation);
        }

        public function getCoupon($idReservation){
            $payment = $this->paymentDAO->getPaymentByIdReservation($idReservation);
            require_once(VIEWS_PATH . 'validate-session.php');
            require_once(VIEWS_PATH . 'viewPaymentCoupon.php');
        }

        public function checkExpirationDate($expirationMonth,$expirationYear,$date){
            $month = date ('m',$date);
            $year = date ('Y',$date);
            if($expirationMonth>=$month && $expirationYear>=$year){
                return true;
            }
            else {
                throw new Exception("Fecha de expiracion invalida");
            }
        }

    }

?>
