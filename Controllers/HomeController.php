<?php
    namespace Controllers;

    class HomeController{
        public function Index(){
            require_once(VIEWS_PATH."inicio.php");
        }

        public function logOut(){
            session_destroy();
            require_once(VIEWS_PATH . "inicio.php");
        }
    }

?>