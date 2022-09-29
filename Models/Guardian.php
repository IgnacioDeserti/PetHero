<?php
	
	namespace Models;
	use Models\Person as Person;

    class Guardian extends Person{
        private $availability;
		private $size;
		private $reviews;

		public function __construct() {
			$this->reviews = array();
		}

	public function getAvailability() {
		return $this->availability;
	}

	public function setAvailability($availability) {
		$this->availability = $availability;
		return $this;
	}

	public function getReviews() {
		return $this->reviews;
	}
	
	public function setReviews($reviews) {
		$this->reviews = $reviews;
		return $this;
	}

	public function getSize() {
		return $this->size;
	}

	public function setSize($size) {
		$this->size = $size;
		return $this;
	}
}

?>