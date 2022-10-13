<?php
    namespace Controllers;

    use DAO\guardiansDAO as GuardianDAO;

    class OwnerController{

        private $ownerDAO;
        private $guardianDAO;


        public function menuOwner($button){
            if($button == "listGuardian")
            {   
                echo 'ola';
                $this->showGuardianList();
            }else if($button == "addDog")
            {
                require_once(VIEWS_PATH."addDog.php");
            }else if($button == "listDog"){
                require_once(VIEWS_PATH."listDog.php");
            }
        }

        public function showGuardianList(){
    
            $Guardians = new GuardianDAO();
            $arrayListGuardian = $Guardians->getAll();
            require_once(VIEWS_PATH."listGuardian.php");
        }

    }

    

?>