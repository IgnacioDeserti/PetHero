<?php
    namespace Controllers;
    include(VIEWS_PATH . "header.php");

    use DAO\guardiansDAO as guardiansDAO;
    use DAO\ownersDAO as ownersDAO;
    use Models\Owner as Owner;
    use Models\Guardian as Guardian;
    use DAO\Guardian_x_SizeDAO;
    use Exception;

    class CreateProfileController{

        private $guardianDAO;
        private $ownerDAO;
        private $gxsDAO;

        public function __construct(){
            $this->guardianDAO = new guardiansDAO();
            $this->ownerDAO = new ownersDAO();
            $this->gxsDAO = new Guardian_x_SizeDAO();
        }

        public function createProfile(){
            require_once(VIEWS_PATH."createProfile.php");
        }

        public function profileType($do){
            if($_POST){
                if($do == "guardian"){
                    require_once(VIEWS_PATH."createGuardianProfile.php");
                }else if($do == "owner"){
                    require_once(VIEWS_PATH."createOwnerProfile.php");
                }else if($do == "goBack"){
                    require_once(VIEWS_PATH."inicio.php");
                }
            }
        }

        public function createOwnerProfile($name, $address, $email, $number, $userName, $password, $typeUser){
            if($_POST){
                
                $this->ownerDAO->getAll();
                $newOwner = new Owner();
                $newOwner->setName($name);
                $newOwner->setAddress($address);
                $newOwner->setEmail($email);
                $newOwner->setNumber($number);
                $newOwner->setUserName($userName);
                $newOwner->setPassword($password);
                $newOwner->setTypeUser($typeUser);

                try{
                    $this->verifyEmailUser($email, $userName);
                    $this->ownerDAO->Add($newOwner);
                    $aux = $this->ownerDAO->getOwner($email);
                    $_SESSION["idUser"] = $aux->getIdOwner();
                    $_SESSION["typeUser"] = $aux->getTypeUser();
                    echo "<script> if(confirm('Perfil creado con exito!')); </script>";
                    require_once(VIEWS_PATH.'addPet.php');
                }catch (Exception $e){
                    require_once(VIEWS_PATH . "createOwnerProfile.php");
                }
                
            }
        }

        private function verifyEmailUser($email, $userName){
            $searched = $this->ownerDAO->getOwner($email);
            if($searched->getEmail() != null){
                throw new Exception("Email ya registrado");
            }else{
                $searched = $this->guardianDAO->getGuardian($email);
                if($searched->getEmail() != null){
                    throw new Exception("Email ya registrado");
                }
            }

            $searched = $this->ownerDAO->getOwnerByUserName($userName);
            if($searched->getUserName() != null){
                throw new Exception("Nombre de usuario ya registrado");
            }else{
                $searched = $this->guardianDAO->getGuardianByUserName($userName);
                if($searched->getUserName() != null){
                    throw new Exception("Nombre de usuario ya registrado");
                }
            }

        }

        public function createGuardianProfile($name, $address, $email, $number, $userName, $password, $size, $typeUser){
            
            if($_POST){

                $newGuardian = new Guardian();
                $newGuardian->setName($name);
                $newGuardian->setAddress($address);
                $newGuardian->setEmail($email);
                $newGuardian->setNumber($number);
                $newGuardian->setUserName($userName);
                $newGuardian->setPassword($password);
                $newGuardian->setTypeUser($typeUser);
            
                try{
                    $this->verifyEmailUser($email, $userName);
                    $this->guardianDAO->Add($newGuardian);
                    $aux = $this->guardianDAO->getGuardian($email);
                    $_SESSION["idUser"] = $aux->getIdGuardian();
                    $_SESSION["typeUser"] = $aux->getTypeUser();
                    foreach($size as $aux){
                        $this->gxsDAO->Add($_SESSION["idUser"], $aux);
                    }
                    echo "<script> if(confirm('Perfil creado con exito!')); </script>";
                    require_once(VIEWS_PATH.'modifyAvailability.php');
                }catch (Exception $e){
                    require_once(VIEWS_PATH . "createGuardianProfile.php");
                }   
            }
        }

    }

?>