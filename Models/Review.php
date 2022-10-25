<?php
    namespace Models;

    class Review{
        
        private $rating;
        private $observations;
        private $idOwner;

    	public function __construct() {
	
        }

		public function getRating() {
			return $this->rating;
		}

		public function setRating($rating) {
			$this->rating = $rating;
		}
		
		public function getObservations() {
			return $this->observations;
		}

		public function setObservations($observations) {
			$this->observations = $observations;
		}

		public function getIdOwner() {
			return $this->idOwner;
		}
		
		public function setIdOwner($idOwner) {
			$this->idOwner = $idOwner;
		}
}

?>