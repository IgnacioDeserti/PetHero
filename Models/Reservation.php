<?php
    namespace Models;

    class Reservation{

        private $idReservation;
        private $idOwner;
        private $idGuardian;
        private $idPet;
        private $breed;
        private $animalType;
        private $size;
        private $reservationDateStart;
        private $reservationDateEnd;
        private $reservationStatus;
        private $price;
        
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
 
        function getReservationStatus(){
            return $this->reservationStatus;
        }
        
        function setReservationStatus($reservationStatus){
            $this->reservationStatus = $reservationStatus;
        }

        public function getReservationDateStart(){
            return $this->reservationDateStart;
        }
        
        public function setReservationDateStart($reservationDateStart){
            $this->reservationDateStart = $reservationDateStart;
        }
        
        public function getReservationDateEnd(){
            return $this->reservationDateEnd;
        }

        public function setReservationDateEnd($reservationDateEnd){
            $this->reservationDateEnd = $reservationDateEnd;
        }

        public function getSize()
        {
                return $this->size;
        }

        public function setSize($size)
        {
                $this->size = $size;

                return $this;
        }

        public function getPrice() {
            return $this->price;
        }
        
        public function setPrice($price){
            $this->price = $price;
        }
}

?>