<?php
    namespace Controllers;

    use DAO\guardiansDAO as GuardianDAO;
    use DAO\guardiansDAO;
    use DAO\ownersDAO;
    use DAO\petDAO;
    use Models\Pet;
    use DAO\ReservationDAO;
    use FFI\Exception;

    class GuardianController{

        private $ownerDAO;
        private $guardianDAO;
        private $PetDAO;
        private $reservationDAO;

        public function __construct(){
            $this->guardianDAO = new guardiansDAO();
            $this->ownerDAO = new ownersDAO();
            $this->PetDAO = new petDAO();
            $this->reservationDAO = new ReservationDAO();
        }

        public function showModifyView($e = null){
            $exception = $e;
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
                    $this->Index();
                }catch (Exception $e) {
                    $this->showModifyView($e);
                } 
        }

        private function verifyAvailability ($avStart, $avEnd){
            if($avStart > $avEnd){
                throw new Exception ("Fechas invalidas, ingrese otras");
            }
        }

        public function showReservationsList (){
            $reservationList = $this->reservationDAO->GetReservationsByGuardian($_SESSION['idUser']);
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "listReservationGuardian.php");
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
                $this->reservationDAO->changeReservationStatus($idReservation,'Aceptada');
                $this->showReservationsList();
            }catch(Exception $e){
                $this->showReservationsList();
            }
        }

        public function declineReservation ($idReservation){
            $this->reservationDAO->changeReservationStatus($idReservation,'Rechazada');
            $this->showReservationsList();
        }

        public function checkGuardian($availabilityStart ,$availabilityEnd, $breed, $type, $size , $idGuardian){
            $flag = 0;
            $listDisponibility = $this->getDisponibilityByGuardian($idGuardian);
    
            $i = 0;
            while($i<count($listDisponibility)){
                if(($availabilityStart>=$listDisponibility[$i]) && ($availabilityStart<=$listDisponibility[$i+1]) && ($availabilityEnd<=$listDisponibility[$i+1]) && ((strcmp($listDisponibility[$i+2],$breed)) || ((strcmp($listDisponibility[$i+2],'all')))) && ((strcmp($listDisponibility[$i+3],$type)) || ((strcmp($listDisponibility[$i+3],'all')))) && ((strcmp($listDisponibility[$i+4],$size)) || (strcmp($listDisponibility[$i+4],'all')))){
                    $flag=1;
                }
                else if(($availabilityStart>=$listDisponibility[$i]) && ($availabilityStart<=$listDisponibility[$i=1]) && ($availabilityEnd>$listDisponibility[$i+1]) && ((strcmp($listDisponibility[$i+2],$breed)) || ((strcmp($listDisponibility[$i+2],'all')))) && ((strcmp($listDisponibility[$i+3],$type)) || ((strcmp($listDisponibility[$i+3],'all')))) && ((strcmp($listDisponibility[$i+4],$size)) || (strcmp($listDisponibility[$i+4],'all')))){
                    $flag=2;
                }
                if($flag==2){
                    if(($availabilityStart<$listDisponibility[$i]) && ($availabilityEnd<=$listDisponibility[$i+1]) && ((strcmp($listDisponibility[$i+2],$breed)) || ((strcmp($listDisponibility[$i+2],'all')))) && ((strcmp($listDisponibility[$i+3],$type)) || ((strcmp($listDisponibility[$i+3],'all')))) && ((strcmp($listDisponibility[$i+4],$size)) || (strcmp($listDisponibility[$i+4],'all')))){
                        $flag=1;
                    }
                    else if(($availabilityStart<$listDisponibility[$i]) && ($availabilityEnd<=$listDisponibility[$i+1]) && (!(strcmp($listDisponibility[$i+2],$breed)) && (!(strcmp($listDisponibility[$i+2],'all')))) && (!(strcmp($listDisponibility[$i+3],$type)) && (!(strcmp($listDisponibility[$i+3],'all')))) && (!(strcmp($listDisponibility[$i+4],$size)) && !(strcmp($listDisponibility[$i+4],'all')))){
                        $flag=0;
                    }
                }
                if((($i+4)==(count($listDisponibility)-1)) && ($flag==2)){
                    $flag=0;
                }
                $i=$i+5;
            }
            if($flag == 0){
                throw new Exception("No se puede aceptar la reserva");
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
                    if(count($listAvailability)>=5 && strcmp($listAvailability[(count($listAvailability))-3],$listReservationsGuardian[$breed]) && (($listAvailability[(count($listAvailability)-4)])+1)<=$listReservationsGuardian[$start] && (((strcmp($listAvailability[(count($listAvailability))-2],$listReservationsGuardian[$type])) || ((strcmp($listAvailability[(count($listAvailability))-2],'all'))))) && strcmp($listAvailability[(count($listAvailability))-1],$listReservationsGuardian[$size])){
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
                else if(count($listAvailability) > 0 && $listAvailability[(count($listAvailability)-5)] <$date && $date <=$listAvailability[(count($listAvailability)-4)]){
                    $date = strtotime($date);
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
        //TODO: aceptar reservas
        //TODO: hacer el arreglo de disponibilidad
    }

?>