<?php
    namespace Controllers;

    use DAO\guardiansDAO as guardiansDAO;
    use DAO\ownersDAO as ownersDAO;
    use Models\Owner as Owner;
    use Models\Guardian as Guardian;
    use DAO\Guardian_x_SizeDAO;
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

                $searched = $this->ownerDAO->getOwner($newOwner);
        
        
                if($searched == NULL){
                    $this->ownerDAO->add($newOwner);
                    echo "<script> if(confirm('Perfil creado con éxito!'));</script>";
                    $_SESSION["idUser"] = $newOwner->getIdOwner();
                    $_SESSION["typeUser"] = $newOwner->getTypeUser();
                    require_once(VIEWS_PATH.'addDog.php');
        
                }else{
                    echo "<script> if(confirm('El email ingresado ya tiene una cuenta registrada, ingrese otro'));</script>";
                    require_once(VIEWS_PATH.'createOwnerProfile.php');
                }
                
            }else{
                echo "<script> if(confirm('Error en el método de envio de datos'));</script>";
                require_once(FRONT_ROOT.'index.php');
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
                
                $this->guardianDAO->add($newGuardian);
                echo "<script> if(confirm('Perfil creado con éxito!'));</script>";
                
                $aux = $this->guardianDAO->getGuardian($newGuardian);

                $_SESSION["idUser"] = $aux->getIdGuardian();

                foreach($size as $aux){
                    $this->gxsDAO->Add($_SESSION["idUser"], $aux);
                }
                $_SESSION["typeUser"] = $newGuardian->getTypeUser();
                require_once(VIEWS_PATH.'guardian.php');
                
            }else{
                echo "<script> if(confirm('Error en el método de envio de datos'));</script>";
                require_once(VIEWS_PATH.'inicio.php');
            }
        }

        

    }

?>