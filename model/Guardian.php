<?php
	include "model/Person.php";
    class Guardian extends Person {
        private $availability;
		private $size;
		private $reviews;

		public function __construct($name = null, $address = null, $email = null, $number = null, $availability = null, $size = null, $reviews = null) {
			parent::__construct($name, $address, $email, $number);
			$this->availability = $availability;
			$this->size = $size;
			$this->reviews = $reviews;
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