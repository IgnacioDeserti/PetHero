<?php
    namespace Controllers;

    use DAO\guardiansDAO as GuardianDAO;
    use DAO\guardiansDAO;
    use DAO\ownersDAO;
    use DAO\dogDAO;
    use Models\Dog;

    class OwnerController{

        private $ownerDAO;
        private $guardianDAO;
        private $dogDAO;

        public function __construct(){
            $this->guardianDAO = new guardiansDAO();
            $this->ownerDAO = new ownersDAO();
            $this->dogDAO = new dogDAO();
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

        public function addDog($name, $breed, $size, $observations, $photo1, $photo2, $video){
                $this->dogDAO->getAll();

                $newDog = new Dog();
                $newDog->setName($name);
                $newDog->setBreed($breed);
                $newDog->setSize($size);
                $newDog->setObservations($observations);
                $newDog->setPhoto1($photo1);
                $newDog->setPhoto2($photo2);
                $newDog->setVideo($video);
                $newDog->setIdOwner($_SESSION["idUser"]);

                $this->dogDAO->add($newDog);

        }

        public function showListDog(){
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "listDog.php");
        }

        public function showAddDog(){
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "addDog.php");
        }

    }

    

?>