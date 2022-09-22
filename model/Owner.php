<?php
	include "model/Person.php";
    class Owner extends Person {
        private $dogs; //ARRAY DE DOGS??

		public function __construct($name = null, $address = null, $email = null, $number = null) {
			parent::__construct($name, $address, $email, $number);
			$this->dogs = array();
		}
	
	function getDogs() {
		return $this->dogs;
	}

	function setDogs($dogs) {
		$this->dogs = $dogs;
		return $this;
	}
}

?>