<?php
    namespace Controllers;

    use DAO\guardiansDAO as GuardianDAO;
    use DAO\guardiansDAO;
    use DAO\ownersDAO;
    use DAO\PaymentCouponDAO;
    use DAO\petDAO;
    use Models\Pet;
    use DAO\ReservationDAO;
    use Exception;

    use PHPMailer\Exception as MailerException;
    use PHPMailer\PHPMailer;


    class GuardianController{

        private $ownerDAO;
        private $guardianDAO;
        private $PetDAO;
        private $reservationDAO;
        private $paymentDAO;

        public function __construct(){
            $this->guardianDAO = new guardiansDAO();
            $this->ownerDAO = new ownersDAO();
            $this->PetDAO = new petDAO();
            $this->reservationDAO = new ReservationDAO();
            $this->paymentDAO = new PaymentCouponDAO();
        }

        public function showModifyView($alert = null){
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "modifyAvailability.php");
        }

        public function Index(){
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "guardian.php");
        }
        
        public function modifyAvailability($availabilityStart = null, $availabilityEnd = null, $id = null){
                try{
                    $this->verifyAvailability($availabilityStart,$availabilityEnd);
                    $this->guardianDAO->UpdateAvailabilityStart($id, $availabilityStart);
                    $this->guardianDAO->UpdateAvailabilityEnd($id, $availabilityEnd);
                    $alert = [
                        "type" => "success",
                        "text" => 'Modificacion realizada con exito'
                    ];
                    $this->showModifyView($alert);
                }catch (Exception $e) {
                    $alert = [
                        "type" => "alert",
                        "text" => $e->getMessage()
                    ];
                    $this->showModifyView($alert);
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

        public function showReservationsList($alert = null){
                $wcReservationList = $this->reservationDAO->getReservationByStatusAndIdGuardian("Esperando confirmacion", $_SESSION['idUser']);
                $fReservationList = $this->reservationDAO->getReservationByStatusAndIdGuardian2("Finalizado", "Finalizado Revisado", $_SESSION['idUser']);
                $cReservationList = $this->reservationDAO->getReservationByStatusAndIdGuardian2("Aceptada",'Esperando pago', $_SESSION['idUser']);
                $allpets = $this->PetDAO;
                $guardian = $this->guardianDAO;
                $owner =$this->ownerDAO;
                $payment = $this->paymentDAO;

                require_once(VIEWS_PATH . "validate-session.php");
                require_once(VIEWS_PATH . "listReservationGuardian.php");
        }

        public function getCoupon($idReservation){
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


        public function selectAction($button, $idReservation){
            if(strcmp($button, "Accept") == 0){
                $this->acceptReservation($idReservation);
            }else{
                $this->declineReservation($idReservation);
            }
        }

        public function acceptReservation ($idReservation){
            try{
                $reservation = $this->reservationDAO->GetReservationsById($idReservation);
                $this->checkGuardian($reservation->getReservationDateStart(), $reservation->getReservationDateEnd(), $reservation->getBreed(), $reservation->getAnimalType(), $reservation->getSize(), $reservation->getIdGuardian());
                $this->reservationDAO->changeReservationStatus($idReservation,'Esperando pago');
                $this->sendEmail($reservation);
                $alert = [
                    "type" => "success",
                    "text" => 'Reserva aceptada con exito, esperando pago!'
                ];
                $this->showReservationsList($alert);
            }catch(Exception $e){
                $alert = [
                    "type" => "alert",
                    "text" => $e->getMessage()
                ];
                $this->showReservationsList($alert);
            }
        }
        

        public function declineReservation ($idReservation){
            try{
                $this->reservationDAO->changeReservationStatus($idReservation,'Rechazada');
                $alert = [
                    "type" => "success",
                    "text" => 'Reserva rechazada con exito!'
                ];
                $this->showReservationsList($alert);
            }catch(Exception $e){
                $alert = [
                    "type" => "alert",
                    "text" => $e->getMessage()
                ];
                $this->showReservationsList($alert);
            }
        }

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

        private function sendEmail($reserva){
            $guardian=$this->guardianDAO->getGuardianById($reserva->getIdGuardian());
            $owner = $this->ownerDAO->GetOwnerById($reserva->GetIdOwner());
            $pet=$this->PetDAO->getPetByIdPet($reserva->getIdPet());

            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host='smtp.gmail.com';
            $mail->SMTPAuth=true;
            $mail->Username='petheroadvisor@gmail.com';
            $mail->Password='Mailer123';
            $mail->SMTPSecure='ssl';
            $mail->Port=465;
            $mail->setFrom('petheroreserves@gmail.com');
            $mail->addAddress($owner->getEmail());
            $mail->isHTML(true);
            $mail->Subject="Confirmacion Reserva - Pet Hero";

            $body="<h1>Buenos dias " . $owner->getName() . "! </h1>" 
            . "\nLa reserva solicitada a " . $guardian->getUserName() . " para cuidar a " . $pet->getName() . " ha sido aceptada!\n" 
            . "desde el dia " . $reserva->getReservationDateStart() . " hasta el " . $reserva->getReservationDateEnd() . "\n" .
            "<h2>--Para contactarse con el guardian:--</h2> \n" .
            "       - Telefono : ". $guardian->getNumber() ."<br>".
            "       -     Mail : ". $guardian->getEmail() ."<br>".
            "Gracias por confiar en Pet Hero!" . "<br>" .
            "(Mail enviado automáticamente, por favor no responder)";

            $mail->Body=$body;

            $mail->send();
        }
    }

    

    /* 
    private $guardianList;
        private $fileName;

        public function __construct(){
            $this->fileName = dirname(__DIR__)."/Data/guardians.json";
        }


        public function add(guardian $newGuardian){
            $this->retrieveData();
            $newGuardian->setIdGuardian($this->setId());
            array_push($this->guardianList, $newGuardian);
            $this->saveData();
        }

        public function getGuardian(Guardian $newGuardian){
            $searched = NULL;
            foreach($this->guardianList as $list){
                if(strcmp($list->getEmail(), $newGuardian->getEmail()) == 0){
                    $searched = $newGuardian;
                }
            }

            return $searched;
        }
        
        public function delete($id){

        }

        public function getAll(){
            $this->retrieveData();
            return $this->guardianList;
        }

        private function saveData(){
            $arrayToEncode = array();

            foreach($this->guardianList as $guardian){
                    $valuesArray["name"] = $guardian->getName();
                    $valuesArray["address"] = $guardian->getAddress();
                    $valuesArray["email"] = $guardian->getEmail();
                    $valuesArray["number"] = $guardian->getNumber();
                    $valuesArray["userName"] = $guardian->getUserName();
                    $valuesArray["password"] = $guardian->getPassword();
                    $valuesArray["size"] = $guardian->getSize();
                    $aux = $guardian->getReviews();
                    $arrayReviews = array();
                    foreach($aux as $review){
                        $value["rating"] = $review->getRating();
                        $value["observations"] = $review->getObservations();
                        $value["userName"] = $review->getUserName();
                        array_push($arrayReviews, $value);
                    }
                    $valuesArray["availabilityStart"] = $guardian->getAvailabilityStart();
                    $valuesArray["availabilityEnd"] = $guardian->getAvailabilityEnd();
                    $valuesArray["reviews"] = $arrayReviews;
                    $valuesArray["idGuardian"] = $guardian->getIdGuardian();
                    $valuesArray["typeUser"] = $guardian->getTypeUser();
                    array_push($arrayToEncode, $valuesArray);
                }

            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

            file_put_contents($this->GetJsonFilePath(), $jsonContent);
        } 

        private function retrieveData(){
            $this->guardianList = array();

            if(file_exists($this->fileName)){
                $jsonContent = file_get_contents($this->GetJsonFilePath());

                $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach($arrayToDecode as $valuesArray){
                    $guardian = new guardian();
                    $guardian->setName($valuesArray["name"]);
                    $guardian->setAddress($valuesArray["address"]);
                    $guardian->setEmail($valuesArray["email"]);
                    $guardian->setNumber($valuesArray["number"]);
                    $guardian->setUserName($valuesArray["userName"]);
                    $guardian->setPassword($valuesArray["password"]);
                    $guardian->setSize($valuesArray["size"]);
                    $aux = $valuesArray["reviews"];
                    $arrayReviews = array();
                    foreach($aux as $value){
                        $review = new Review();
                        $review->setRating($value["rating"]);
                        $review->setObservations($value["observations"]);
                        $review->setUserName($value["userName"]);
                        array_push($arrayReviews, $review);
                    }
                    $guardian->setAvailabilityStart($valuesArray["availabilityStart"]);
                    $guardian->setAvailabilityEnd($valuesArray["availabilityEnd"]);
                    $guardian->setReviews($arrayReviews);
                    $guardian->setIdGuardian($valuesArray["idGuardian"]);
                    $guardian->setTypeUser($valuesArray["typeUser"]);
                    array_push($this->guardianList, $guardian);
                }
            }
        }

        private function GetJsonFilePath(){

            $initialPath = "Data/guardians.json";
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

        public function UpdateAvailability($id, $date1, $date2){
            foreach($this->getAll() as $guardian){
                if($guardian->getIdGuardian() == $id){
                    $guardian->setAvailabilityStart($date1);
                    $guardian->setAvailabilityEnd($date2);
                    $this->saveData();
                }
                
            }
        }
}
*/
?>