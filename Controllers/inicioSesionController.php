<?php
    namespace Controllers;

    use DAO\petDAO;
    use DAO\guardiansDAO as guardiansDAO;
    use DAO\ownersDAO as ownersDAO;
    use DAO\sizeDAO;
    use Exception;
    class InicioSesionController{

        private $guardianDAO;
        private $ownerDAO;
        private $petsDAO;
        private $sizeDAO;

        public function __construct(){
            $this->guardianDAO = new guardiansDAO();
            $this->ownerDAO = new ownersDAO();
            $this->petsDAO = new petDAO();
            $this->sizeDAO = new sizeDAO();
        }

        public function inicioSesion($email, $password, $typeUser){
            if($typeUser == 'G'){
                try{
                    $aux = $this->searchGuardian($email, $password);
                    $_SESSION["idUser"] = $aux->getIdGuardian();
                    $_SESSION["typeUser"] = $aux->getTypeUser();
                    $this->selectViewGuardian($aux);
                }catch(Exception $e){
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
            $arrayListPet = array();
            foreach($this->petsDAO->getAll() as $Pet){
                if($Pet->getIdOwner() == $id){
                    array_push($arrayListPet, $Pet);
                }
            }

            if(empty($arrayListPet)){
                require_once(VIEWS_PATH . "validate-session.php");
                require_once(VIEWS_PATH . "addPet.php");
            }else{
                $sizeList = $this->sizeDAO->getAll();
                require_once(VIEWS_PATH . "validate-session.php");
                require_once(VIEWS_PATH . "listPet.php");
            }
        }

        public function selectViewGuardian($aux){
            if($aux->getAvailabilityStart() == null && $aux->getAvailabilityEnd() == null){
                require_once(VIEWS_PATH . "modifyAvailability.php");
            }else{
                require_once(VIEWS_PATH . "guardian.php");
            }
        }

        
    }

?>