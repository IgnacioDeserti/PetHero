<?php
    namespace Models;

    class Guardian_x_Size{
        private $idGuardianxSize;
        private $idGuardian;
        private $idSize;

        public function __construct(){
        
        }

        function getIdGuardianxSize() {
            return $this->idGuardianxSize;
        }
        
        function setIdGuardianxSize($idGuardianxSize){
            $this->idGuardianxSize = $idGuardianxSize;
        }

        function getIdGuardian() {
            return $this->idGuardian;
        }

        function setIdGuardian($idGuardian){
            $this->idGuardian = $idGuardian;
        }

        function getIdSize() {
            return $this->idSize;
        }
        
        function setIdSize($idSize){
            $this->idSize = $idSize;
        }
}

?>