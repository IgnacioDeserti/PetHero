<?php
    namespace Controllers;

    use DAO\guardiansDAO as guardiansDAO;
    use DAO\ownersDAO as ownersDAO;
    class CreateProfileController{

        private $guardianDAO;
        private $ownerDAO;

        public function __construct(){
            $this->guardianDAO = new guardiansDAO();
            $this->ownerDAO = new ownersDAO();
        }

        public function createProfile(){
            require_once(VIEWS_PATH."createProfile.php");
        }

        public function profileType($do){
            if($_POST){
                if($do == "guardian"){
                    require_once(VIEWS_PATH."createGuardianProfile.php");
                }else{
                    require_once(VIEWS_PATH."createOwnerProfile.php");
                }
            }
        }


    }

?>