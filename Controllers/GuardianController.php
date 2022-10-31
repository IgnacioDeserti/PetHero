<?php
    namespace Controllers;

    use DAO\guardiansDAO as GuardianDAO;
    use DAO\guardiansDAO;
    use DAO\ownersDAO;
    use DAO\petDAO;
    use Models\Pet;

    class GuardianController{

        private $ownerDAO;
        private $guardianDAO;
        private $PetDAO;

        public function __construct(){
            $this->guardianDAO = new guardiansDAO();
            $this->ownerDAO = new ownersDAO();
            $this->PetDAO = new petDAO();
        }

        public function showModifyView(){
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "modifyAvailability.php");
        }

        public function Index(){
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "guardian.php");
        }
        
        public function modifyAvailability($availabilityStart = null, $availabilityEnd = null, $id = null){
            if($availabilityStart > $availabilityEnd){
                echo "<script> if(confirm('Fechas invalidas, ingrese otras'));</script>";
                $this->showModifyView();
            }
            if($availabilityStart != null && $availabilityEnd != null){
                $this->guardianDAO->UpdateAvailabilityStart($id, $availabilityStart);
                $this->guardianDAO->UpdateAvailabilityEnd($id, $availabilityEnd);
                //echo "<script> if(confirm('Cambio realizado con exito!));</script>";
                //$this->Index();
            }else{
                echo "<script> if(confirm('A seleccionar disponibilidad!));</script>";
                $this->showModifyView();
            }
        }
    }

?>