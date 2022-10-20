<?php
    namespace Controllers;

    use DAO\dogDAO;
    use DAO\guardiansDAO as guardiansDAO;
    use DAO\ownersDAO as ownersDAO;
    class InicioSesionController{

        private $guardianDAO;
        private $ownerDAO;
        private $dogsDAO;

        public function __construct(){
            $this->guardianDAO = new guardiansDAO();
            $this->ownerDAO = new ownersDAO();
            $this->dogsDAO = new dogDAO();
        }

        public function inicioSesion($email, $password){
        
            $loggedUser = NULL;
            
            if($_POST){
                foreach($this->ownerDAO->getAll() as $owner){
                    if($email == $owner->getEmail()){
                        if($password == $owner->getPassword()){
                            $loggedUser = $owner;
                            $_SESSION['idUser'] = $loggedUser->getIdOwner();
                            $_SESSION['typeUser'] = $loggedUser->getTypeUser();
                            $_SESSION['name'] = $loggedUser->getName();
                            echo "<script> if(confirm('Iniciaste sesion como Dueño con Exito!'));</script>";
                            $this->selectView($loggedUser->getIdOwner());
                        }
                    }
                }
                if($loggedUser == NULL){
                    foreach($this->guardianDAO->getAll() as $guardian){
                        if($email == $guardian->getEmail()){
                            if($password == $guardian->getPassword()){
                                $loggedUser = $guardian;

                                $_SESSION['idUser'] = $loggedUser->getIdGuardian();
                                $_SESSION['typeUser'] = $loggedUser->getTypeUser();
                                $_SESSION['name'] = $loggedUser->getName();
                                echo "<script> if(confirm('Iniciaste sesion como Guardian con Exito!'));</script>";
                               require_once(VIEWS_PATH. "guardian.php");
                            }
                        }
                    }
                }
                if($loggedUser == null){
                    echo "<script> if(confirm('Verifique que los datos ingresados sean correctos'));</script>";
                    require_once(VIEWS_PATH . "inicio.php");
                }
        
            }else{
                echo "<script> if(confirm('Error en el método de envio de datos'));</script>";
                require_once(VIEWS_PATH . "inicio.php");
            }
        
        }

        public function selectView($id){
            $dogList = array();
            foreach($this->dogsDAO->getAll() as $dog){
                if($dog->getIdOwner() == $id){
                    array_push($dogList, $dog);
                }
            }

            if(empty($dogList)){
                require_once(VIEWS_PATH . "validate-session.php");
                require_once(VIEWS_PATH . "addDog.php");
            }else{
                require_once(VIEWS_PATH . "validate-session.php");
                require_once(VIEWS_PATH . "listDog.php");
            }
        }

        


    }

?>