<?php
    namespace Models;

    class Review{
        
		private $idReview;
        private $rating;
        private $observations;
        private $idOwner;
        private $idGuardian;
		private $idReservation;
		
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

		public function getIdReview()
		{
			return $this->idReview;
		}

		public function setIdReview($idReview)
		{
			$this->idReview = $idReview;
		}

        public function getIdGuardian()
        {
            return $this->idGuardian;
        }

        public function setIdGuardian($idGuardian)
        {
            $this->idGuardian = $idGuardian;
        }

		public function getIdReservation()
		{
			return $this->idReservation;
		}

		public function setIdReservation($idReservation)
		{
			$this->idReservation = $idReservation;
		}
}

?>