<?php
    namespace Controllers;

    use DAO\guardiansDAO as GuardianDAO;
    use DAO\guardiansDAO;
    use DAO\ownersDAO;
    use DAO\petDAO;
    use Models\Pet;
    use FFI\Exception;

    class GuardianController{

        private $ownerDAO;
        private $guardianDAO;
        private $PetDAO;

        public function __construct(){
            $this->guardianDAO = new guardiansDAO();
            $this->ownerDAO = new ownersDAO();
            $this->PetDAO = new petDAO();
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

        //TODO: aceptar reservas
        //TODO: hacer el arreglo de disponibilidad
    }

?>