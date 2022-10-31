<?php
    namespace Models;

    class Size{

        private $idSize;
        private $name;

        
        public function __construct(){
            
        }

        function getIdSize() {
            return $this->idSize;
        }
        
        function setIdSize($idSize){
            $this->idSize = $idSize;
        }
        
        function getName(){
            return $this->name;
        }

        function setName($name){
            $this->name = $name;
        }
}


?>