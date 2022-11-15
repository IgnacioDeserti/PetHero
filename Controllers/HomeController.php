<?php
    namespace Controllers;

    use DAO\petDAO;
    use DAO\guardiansDAO as guardiansDAO;
    use DAO\ownersDAO as ownersDAO;
    use DAO\sizeDAO;
    use Models\Owner as Owner;
    use DAO\Guardian_x_SizeDAO;
    use Models\Guardian as Guardian;
    use DAO\ReservationDAO;
    use Exception;

    class HomeController{

        private $guardianDAO;
        private $ownerDAO;
        private $PetDAO;
        private $sizeDAO;
        private $gxsDAO;
        private $reservationDAO;

        public function __construct(){
            $this->guardianDAO = new guardiansDAO();
            $this->ownerDAO = new ownersDAO();
            $this->PetDAO = new petDAO();
            $this->sizeDAO = new sizeDAO();
            $this->gxsDAO = new Guardian_x_SizeDAO();
            $this->reservationDAO = new ReservationDAO();
        }

        public function Index(){
            require_once(VIEWS_PATH."inicio.php");
        }

        public function logOut(){
            session_destroy();
            require_once(VIEWS_PATH . "inicio.php");
        }

        public function inicioSesion($email, $password, $typeUser){
            if($typeUser == 'G'){
                try{
                    $aux = $this->searchGuardian($email, $password);
                    $_SESSION["idUser"] = $aux->getIdGuardian();
                    $_SESSION["typeUser"] = $aux->getTypeUser();
                    $this->selectViewGuardian($aux);
                }catch(Exception $e){

                    $alert = [
                        "type" => "error",
                        "text" => $e->getMessage()
                    ];
                    require_once(VIEWS_PATH . "inicio.php");
                }
            }else{
                try{
                    $aux = $this->searchOwner($email, $password);
                    $_SESSION["idUser"] = $aux->getIdOwner();
                    $_SESSION["typeUser"] = $aux->getTypeUser();
                    $this->selectView($aux->getIdOwner());
                }catch(Exception $e){
                    require_once(VIEWS_PATH . "inicio.php");
                }
            }
        
        }

        public function searchOwner($email, $password){
            $aux = $this->ownerDAO->getOwner($email);

            if($aux->getEmail() != null){
                if(strcmp($aux->getPassword(), $password) == 0){
                    return $aux;
                }else{
                    throw new Exception("Password invalida");
                }
            }else{
                throw new Exception("Email invalido");
            }
        }

        public function searchGuardian($email, $password){
            $aux = $this->guardianDAO->getGuardian($email);

            if($aux->getEmail() != null){
                if(strcmp($aux->getPassword(), $password) == 0){
                    return $aux;
                }else{
                    throw new Exception("Password invalida");
                }
            }else{
                throw new Exception("Email invalido");
            }
        }

        public function selectView($id){

            $arrayListPet = $this->PetDAO->GetPetByIdOwner($id);

            if(empty($arrayListPet)){
                require_once(VIEWS_PATH . "validate-session.php");
                require_once(VIEWS_PATH . "addPet.php");
            }else{
                $size = $this->sizeDAO;
                require_once(VIEWS_PATH . "validate-session.php");
                require_once(VIEWS_PATH . "listPet.php");
            }
        }

        public function selectViewGuardian($aux){
            if($aux->getAvailabilityStart() == null && $aux->getAvailabilityEnd() == null){
                require_once(VIEWS_PATH . "modifyAvailability.php");
            }else{
                $wcReservationList = $this->reservationDAO->getReservationByStatusAndIdGuardian("Esperando confirmacion", $_SESSION['idUser']);
                $fReservationList = $this->reservationDAO->getReservationByStatusAndIdGuardian("Finalizado", $_SESSION['idUser']);
                $cReservationList = $this->reservationDAO->getReservationByStatusAndIdGuardian("Aceptada", $_SESSION['idUser']);
                $allpets = $this->PetDAO;
                $guardian = $this->guardianDAO;
                $owner =$this->ownerDAO;
                
                require_once(VIEWS_PATH . "validate-session.php");
                require_once(VIEWS_PATH . "listReservationGuardian.php");
            }
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

        public function createGuardianProfile($name, $address, $email, $number, $userName, $password, $size, $price, $typeUser){
            
            if($_POST){

                $newGuardian = new Guardian();
                $newGuardian->setName($name);
                $newGuardian->setAddress($address);
                $newGuardian->setEmail($email);
                $newGuardian->setNumber($number);
                $newGuardian->setUserName($userName);
                $newGuardian->setPassword($password);
                $newGuardian->setPrice($price);
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