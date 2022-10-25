<?php
    namespace Models;

    class Reserve{
        private $idOwner;
        private $idGuardian;
        private $idDog;
        private $idReserve;
        private $breed;
        private $animalType;
        private $date;
        private $status;
        private $review;

        public function __construct(){
            
        }

        
        function getIdOwner(){
            return $this->idOwner;
        }

        function setIdOwner($idOwner){
            $this->idOwner = $idOwner;
            return $this;
        }
        
        function getIdGuardian(){
            return $this->idGuardian;
        }
        
        function setIdGuardian($idGuardian){
            $this->idGuardian = $idGuardian;
        }

        function getIdDog(){
            return $this->idDog;
        }
        
        function setIdDog($idDog){
            $this->idDog = $idDog;
        }
        
        function getIdReserve(){
            return $this->idReserve;
        }

        function setIdReserve($idReserve){
            $this->idReserve = $idReserve;
        }

        function getBreed(){
            return $this->breed;
        }

        function setBreed($breed){
            $this->breed = $breed;
        }
        
        function getAnimalType(){
            return $this->animalType;
        }

        function setAnimalType($animalType){
            $this->animalType = $animalType;
        }

        function getDate(){
            return $this->date;
        }
        
        function setDate($date){
            $this->date = $date;
        }
 
        function getStatus(){
            return $this->status;
        }
        
        function setStatus($status){
            $this->status = $status;
        }
 
        function getReview(){
            return $this->review;
        }
}

?>