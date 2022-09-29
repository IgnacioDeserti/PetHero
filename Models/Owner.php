<?php
	
	namespace Models;
	use Models\Person as Person;

    class Owner extends Person {
        private $dogs; //ARRAY DE DOGS??

		public function __construct() {
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