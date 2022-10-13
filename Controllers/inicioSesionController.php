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
                    if($_POST['email'] == $owner->getEmail()){
                        if($_POST['password'] == $owner->getPassword()){
                            $loggedUser = $owner;
                            session_start();
                            $_SESSION['loggedUser'] = $loggedUser;
                            require_once(VIEWS_PATH. "owner.php");
                        }
                    }
                }
                if($loggedUser == NULL){
                    foreach($this->guardianDAO->getAll() as $guardian){
                        if($_POST['email'] == $guardian->getEmail()){
                            if($_POST['password'] == $guardian->getPassword()){
                                $loggedUser = $guardian;
                                session_start();
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