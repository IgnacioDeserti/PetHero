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
        public function filterGuardians($alert = null){
            try{
                date_default_timezone_set("America/Buenos_Aires");
                $date = strtotime('today');
                $listPets = $this->PetDAO->GetPetByIdOwner($_SESSION["idUser"]);
                require_once(VIEWS_PATH . "validate-session.php");
                require_once(VIEWS_PATH . "filterGuardianList.php");
            }catch(Exception $e){
                $alert = [
                    "type" => "alert",
                    "text" => $e->getMessage()
                ];
                require_once(VIEWS_PATH . "validate-session.php");
                require_once(VIEWS_PATH . "filterGuardianList.php");
            }
        }

        private function verifyAvailability ($avStart, $avEnd){
            date_default_timezone_set("America/Buenos_Aires");
            $date = strtotime('today');
            $date = date("Y-m-d", $date);
            if($avStart > $avEnd){
                throw new Exception ("Fechas invalidas, ingrese otras");
            }
            if($avStart < $date){
                throw new Exception ("Fechas invalidas, ingrese otras");
            }
        }

        //llama al checkeo 
        public function showGuardianList($availabilityStart ,$availabilityEnd, $idPet){
            try{
                $this->verifyAvailability($availabilityStart, $availabilityEnd);
                try{
                    $listGuardian = $this->guardianDAO->getAll();
                    $listGuardianSize = array();
                    try{
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

                    }catch(Exception $e){
                        $alert = [
                            "type" => "alert",
                            "text" => $e->getMessage()
                        ];
                        $this->showAddPet($alert);
                    }
                    
                }catch(Exception $e){
                    $alert = [
                        "type" => "alert",
                        "text" => $e->getMessage()
                    ];
                    $this->showListPet($alert);
                }
            
        }catch(Exception $e){
            $alert = [
                "type" => "alert",
                "text" => $e->getMessage()
            ];
            $this->filterGuardians($alert);
        }
    }

        //checkea que la disponibilidad deseada este dentro de la disponibilidad del guardian
        public function checkGuardian($availabilityStart ,$availabilityEnd, $breed, $type, $size, $idGuardian){
            $flag = 0;
            $listDisponibility = $this->getDisponibilityByGuardian($idGuardian);

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

        public function addPet($name, $breed, $size, $observations, $type, $files){;
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

            try{
                $this->PetDAO->add($newPet);
                $alert = [
                    "type" => "success",
                    "text" => "Mascota agregada con Exito!"
                ];
                $this->showListPet($alert);
            }catch(Exception $e){
                $alert = [
                    "type" => "error",
                    "text" => $e->getMessage()
                ];
                $this->showAddPet($alert);
            }
        }

        public function showListPet($alert = null)
        {   
            try{
                $arrayListPet = $this->PetDAO->GetPetByIdOwner($_SESSION["idUser"]);
                $size = $this->sizeDAO;
                if(count($arrayListPet) > 0){
                    require_once(VIEWS_PATH . "validate-session.php");
                    require_once(VIEWS_PATH . "listPet.php");
                }else{
                    throw new Exception("No tienes mascotas");
                }
            }catch (Exception $e){
                $alert = [
                    "type" => "alert",
                    "text" => $e->getMessage()
                ];
                $this->showAddPet($alert);
            }
        }

        public function showAddPet($alert = null)
        {
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "addPet.php");
        }

        public function selectGuardian($availabilityStart, $availabilityEnd, $idPet, $email){
            try{
                $guardian = $this->guardianDAO->getGuardian($email);
                $arrayListSize = $this->sizeDAO->getAll();
                $arrayListGuardianxSize = $this->guardian_x_sizeDAO->getAll();
                $reviewsList = $this->reviewDAO->GetReviewsByGuardian($guardian->getIdGuardian());
                $ownerList = $this->ownerDAO;
                $alert = [
                    "type" => "success",
                    "text" => "Guardian seleccionado correctamente!"
                ];
                require_once(VIEWS_PATH . "validate-session.php");
                require_once(VIEWS_PATH . "showGuardian.php");
            }catch(Exception $e){
                $alert = [
                    "type" => "alert",
                    "text" => $e->getMessage()
                ];
                $this->filterGuardians($alert);
            }   
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
                        $alert = [
                            "type" => "success",
                            "text" => "Solicitud enviada con exito!"
                        ];
                        $this->showReservationsList($alert);
                    }
                }catch (Exception $e){
                    $alert = [
                        "type" => "success",
                        "text" => "Solicitud enviada con exito!"
                    ];
                    $this->filterGuardians($alert);
                }
        }

        public function showReservationsList($alert = null){
            $wcReservationList = $this->reservationDAO->getReservationByStatusAndIdOwner("Esperando confirmacion", $_SESSION['idUser']);
            $fReservationList = $this->reservationDAO->getReservationByStatusAndIdOwner("Finalizado", $_SESSION['idUser']);
            $cReservationList = $this->reservationDAO->getReservationByStatusAndIdOwner2("Aceptada", "Esperando pago", $_SESSION['idUser']);
            $allpets = $this->PetDAO;
            $guardian = $this->guardianDAO;
            $owner = $this->ownerDAO;
            
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

        public function chargeCard($idReservation, $alert = null){
            require_once(VIEWS_PATH . 'validate-session.php');
            require_once(VIEWS_PATH . 'chargeCard.php');
        }

        public function chargePayment ($cardNumber, $titular ,$expirationDate,$secCode,$idReservation){
            date_default_timezone_set("America/Buenos_Aires");
            $date = strtotime('today');
            try{   
                $this->checkExpirationDate($expirationDate,$date);
                $this->createPayment($titular,$date, $idReservation);
            }catch (Exception $e){
                $alert = [
                    "type" => "alert",
                    "text" => $e->getMessage()
                ];
                $this->chargeCard($idReservation, $alert);
            } 
        }

        public function createPayment($titular,$date,$idReservation){
            $payment = new PaymentCoupon();
            $date = date("Y-m-d", $date);
            try{
                $reservation = $this->reservationDAO->GetReservationsById($idReservation);
                $payment->setOwnerName($this->ownerDAO->GetNameById($reservation->getIdOwner()));
                $payment->setGuardianName(($this->guardianDAO->getGuardianById($reservation->getIdGuardian()))->getName());
                $payment->setPetName(($this->PetDAO->getPetByIdPet($reservation->getIdPet()))->getName());
                $payment->setPrice($reservation->getPrice()/2);
                $payment->setDate($date);
                $payment->setTitular($titular);
                $payment->setReservationNumber($reservation->getIdReservation());
                $this->reservationDAO->changeReservationStatus($idReservation, "Aceptada");
                $this->reservationDAO->updatePrice($idReservation);
                $this->paymentDAO->Add($payment);
                $alert = [
                    "type" => "success",
                    "text" => "Pago realizado con exito!"
                ];
                $this->getCoupon($idReservation, $alert);
            }catch(Exception $e){
                $alert = [
                    "type" => "alert",
                    "text" => $e->getMessage()
                ];
                $this->showReservationsList($alert);
            }

        }

        public function getCoupon($idReservation, $alert = null){
            try{
                $paymentArray = $this->paymentDAO->getPaymentByIdReservation($idReservation);
                if(count($paymentArray) > 0){
                    $payment = $paymentArray[0];
                    require_once(VIEWS_PATH . "validate-session.php");
                    require_once(VIEWS_PATH . "viewPaymentCoupon.php");
                }else{
                    throw new Exception("La reserva no tiene pago aun");
                }
            }catch(Exception $e){
                $alert = [
                    "type" => "alert",
                    "text" => $e->getMessage()
                ];
                $this->showReservationsList($alert);
            }
        }

        public function checkExpirationDate($expirationDate,$date){
            $date = date("Y-m", $date);
            if($expirationDate>=$date){
                return true;
            }
            else {
                throw new Exception("Fecha de expiracion invalida");
            }

        }

        public function deletePet ($idPet){

            try{
                $this->PetDAO->deletePet($idPet);
                $alert = [
                    "type" => "success",
                    "text" => 'Mascota eliminada correctamente'
                ];
                $this->showListPet($alert);
            }catch (Exception $e){
                $alert = [
                    "type" => "alert",
                    "text" => $e->getMessage()
                ];
                $this->showListPet($alert);
            }

        }

    }

    /* 
    private $ownerList;
        private $fileName;
        private $dogDAO;

        public function __construct(){
            $this->fileName = dirname(__DIR__)."/Data/owners.json";
            $this->dogDAO = new DogDAO();
        }


        public function add(Owner $newOwner){
            $this->retrieveData();
            $newOwner->setIdOwner($this->setId());
            array_push($this->ownerList, $newOwner);
            $this->saveData();
        }
        
        public function delete($id){

        }

        public function getAll(){
            $this->retrieveData();
            return $this->ownerList;
        }

        public function getOwner(Owner $newOwner){
            $searched = NULL;

            foreach($this->ownerList as $list){
                if(strcmp($list->getEmail(), $newOwner->getEmail()) == 0){
                    $searched = $newOwner;
                }
            }

            return $searched;
        }

        private function saveData(){
            $arrayToEncode = array();

            foreach($this->ownerList as $owner){
                    $valuesArray["name"] = $owner->getName();
                    $valuesArray["address"] = $owner->getAddress();
                    $valuesArray["email"] = $owner->getEmail();
                    $valuesArray["number"] = $owner->getNumber();
                    $valuesArray["userName"] = $owner->getUserName();
                    $valuesArray["password"] = $owner->getPassword();
                    $valuesArray["idOwner"] = $owner->getIdOwner();
                    $valuesArray["typeUser"] = $owner->getTypeUser();
                    array_push($arrayToEncode, $valuesArray);
                }

            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

            file_put_contents($this->GetJsonFilePath(), $jsonContent);
        } 

        private function retrieveData(){
            $this->ownerList = array();
            if(file_exists($this->fileName)){
                $jsonContent = file_get_contents($this->GetJsonFilePath());

                $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach($arrayToDecode as $valuesArray){
                    $owner = new Owner();
                    $owner->setName($valuesArray["name"]);
                    $owner->setAddress($valuesArray["address"]);
                    $owner->setEmail($valuesArray["email"]);
                    $owner->setNumber($valuesArray["number"]);
                    $owner->setUserName($valuesArray["userName"]);
                    $owner->setPassword($valuesArray["password"]);
                    $owner->setIdOwner($valuesArray["idOwner"]);
                    $owner->setTypeUser($valuesArray["typeUser"]);
                    array_push($this->ownerList, $owner);
                }
            }
        }

        private function GetJsonFilePath(){

            $initialPath = "Data/owners.json";
            if(file_exists($initialPath)){
                $jsonFilePath = $initialPath;
            }else{
                $jsonFilePath = "../".$initialPath;
            }

            return $jsonFilePath;
        }

        private function setId(){
            return count($this->getAll()) + 1;
        }
}
*/

?>
