<?php
    namespace Controllers;

    use DAO\guardiansDAO;
    use DAO\ownersDAO;
    class OwnerController{

        private $ownerDAO;
        private $guardianDAO;


        public function menuOwner($button){
            if($button == "listGuardian"){
                require_once(VIEWS_PATH."listGuardian.php");
            }else if($button == "addDog"){
                require_once(VIEWS_PATH."addDog.php");
            }else if($button == "listDog"){
                require_once(VIEWS_PATH."listDog.php");
            }
        }


    }

?>