<?php
    namespace Controllers;

    use DAO\guardiansDAO as guardiansDAO;
    use DAO\ownersDAO as ownersDAO;
    use Models\Owner as Owner;
    use Models\Guardian as Guardian;
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
                }else if($do == "owner"){
                    require_once(VIEWS_PATH."createOwnerProfile.php");
                }else if($do == "goBack"){
                    require_once(VIEWS_PATH."inicio.php");
                }else{
                    
                }
            }
        }

        public function createOwnerProfile($name, $address, $email, $number, $userName, $password){
            if($_POST){

                $newOwner = new Owner();
                $newOwner->setName($name);
                $newOwner->setAddress($address);
                $newOwner->setEmail($email);
                $newOwner->setNumber($number);
                $newOwner->setUserName($userName);
                $newOwner->setPassword($password);
                
                $searched = $this->ownerDAO->getOwner($newOwner);
        
        
                if($searched == NULL){
                    $this->ownerDAO->add($newOwner);
                    echo "<script> if(confirm('Perfil creado con éxito!'));";
                    echo "window.location = '../Views/owner.php';
                    </script>";
        
                }else{
                    echo "<script> if(confirm('Nombre de usuario ya registrado, ingrese otro'));";
                    echo "window.location = '../Views/createOwnerProfile.php';
                    </script>";
                }
                
            }else{
                echo "<script> if(confirm('Error en el método de envio de datos'));";
                echo "window.location = '../index.php';
                </script>";
            }
        }

        public function createGuardianProfile($name, $address, $email, $number, $userName, $password, $size){
            
            if($_POST){

                $newGuardian = new Guardian();
                $newGuardian->setName($name);
                $newGuardian->setAddress($address);
                $newGuardian->setEmail($email);
                $newGuardian->setNumber($number);
                $newGuardian->setUserName($userName);
                $newGuardian->setPassword($password);
                $newGuardian->setSize($size);
                
                $searched = $this->guardianDAO->getGuardian($newGuardian);
        
        
                if($searched == NULL){
                    $this->guardianDAO->add($newGuardian);
                    echo "<script> if(confirm('Perfil creado con éxito!'));";
                    echo "window.location = '../Views/guardian.php';
                    </script>";
        
                }else{
                    echo "<script> if(confirm('Nombre de usuario ya registrado, ingrese otro'));";
                    echo "window.location = '../Views/createGuardianProfile.php';
                    </script>";
                }
                
            }else{
                echo "<script> if(confirm('Error en el método de envio de datos'));";
                echo "window.location = '../Views/inicio.php';
                </script>";
            }
        }

    }

?>