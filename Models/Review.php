<?php
    namespace Models;

    class Review{
        
        private $rating;
        private $observations;
        private $userName;

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

	public function getUserName() {
		return $this->userName;
	}
	
	public function setUserName($userName) {
		$this->userName = $userName;
	}
}

?>