<?php
    namespace Controllers;

    use DAO\guardiansDAO as guardiansDAO;
    use DAO\ownersDAO as ownersDAO;
    class InicioSesionController{

        private $guardianDAO;
        private $ownerDAO;

        public function __construct(){
            $this->guardianDAO = new guardiansDAO();
            $this->ownerDAO = new ownersDAO();
        }

        public function inicioSesion($email, $password){
        
            $loggedUser = NULL;
            
            if($_POST){
                foreach($this->ownerDAO->getAll() as $owner){
                    if($email == $owner->getEmail()){
                        if($password == $owner->getPassword()){
                            $loggedUser = $owner;
                            $_SESSION['loggedUser'] = $loggedUser;
                            require_once(VIEWS_PATH. "owner.php");
                        }
                    }
                }
                if($loggedUser == NULL){
                    foreach($this->guardianDAO->getAll() as $guardian){
                        if($email == $guardian->getEmail()){
                            if($password == $guardian->getPassword()){
                                $loggedUser = $guardian;

                                $_SESSION['loggedUser'] = $loggedUser;
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

        


    }

?>