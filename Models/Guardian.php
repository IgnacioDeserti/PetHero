<?php
	
	namespace Models;
	use Models\Person as Person;

    class Guardian extends Person{
        private $availabilityStart;
		private $availabilityEnd;
		private $size;
		private $reviews;

		public function __construct(){
			$this->reviews = array();
		}

		public function getReviews(){
			return $this->reviews;
		}
		
		public function setReviews($reviews){
			$this->reviews = $reviews;
		}

		public function getSize(){
			return $this->size;
		}

		public function setSize($size){
			$this->size = $size;
		}

		public function getAvailabilityStart(){
			return $this->availabilityStart;
		}
		
		public function setAvailabilityStart($availabilityStart){
			$this->availabilityStart = $availabilityStart;
		}

		public function getAvailabilityEnd(){
			return $this->availabilityEnd;
		}
		
		public function setAvailabilityEnd($availabilityEnd){
			$this->availabilityEnd = $availabilityEnd;
		}
}

?>