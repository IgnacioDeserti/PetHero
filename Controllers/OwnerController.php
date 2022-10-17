<?php
    namespace Controllers;

    use DAO\guardiansDAO as GuardianDAO;
    use DAO\guardiansDAO;
    use DAO\ownersDAO;

    class OwnerController{

        private $ownerDAO;
        private $guardianDAO;

        public function __construct(){
            $this->guardianDAO = new guardiansDAO();
            $this->ownerDAO = new ownersDAO();
        }


        public function menuOwner($button){
            if($button == "listGuardian"){   
                require_once(VIEWS_PATH . "validate-session.php");
                $this->showGuardianList();
            }else if($button == "addDog"){
                require_once(VIEWS_PATH . "validate-session.php");
                require_once(VIEWS_PATH."addDog.php");
            }else if($button == "listDog"){
                require_once(VIEWS_PATH . "validate-session.php");
                require_once(VIEWS_PATH."listDog.php");
            }
        }

        public function showGuardianList(){
    
            $arrayListGuardian = $this->guardianDAO->getAll();
            require_once(VIEWS_PATH."listGuardian.php");
        }

    }

    

?>