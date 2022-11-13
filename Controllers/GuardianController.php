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

        public function aceptReservation ($idReservation){
            $this->reservationDAO->changeReservationStatus($idReservation,'Aceptada');
        }

        public function declineReservation ($idReservation){
            $this->reservationDAO->changeReservationStatus($idReservation,'Rechazada');
        }



        //TODO: aceptar reservas
        //TODO: hacer el arreglo de disponibilidad
    }

?>