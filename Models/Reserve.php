<?php
    namespace Models;

    class Reservation{

        private $idReservation;
        private $idOwner;
        private $idGuardian;
        private $idPet;
        private $breed;
        private $animalType;
        private $reservationDate;
        private $reservationStatus;
        
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

        function getIdPet(){
            return $this->idPet;
        }
        
        function setIdPet($idPet){
            $this->idPet = $idPet;
        }
        
        function getIdReservation(){
            return $this->idReservation;
        }

        function setIdReservation($idReservation){
            $this->idReservation = $idReservation;
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

        function getReservationDate(){
            return $this->reservationDate;
        }
        
        function setReservationDate($reservationDate){
            $this->reservationDate = $reservationDate;
        }
 
        function getReservationStatus(){
            return $this->reservationStatus;
        }
        
        function setReservationStatus($reservationStatus){
            $this->reservationStatus = $reservationStatus;
        }
}

?>