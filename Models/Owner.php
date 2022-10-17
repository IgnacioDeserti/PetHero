<?php
	
	namespace Models;
	use Models\Person as Person;
	use Models\Dog;

    class Owner extends Person {
        private $dogs;
		private $idOwner;

		public function __construct() {
			parent::__construct();
			$this->dogs = array();
		}
	
		public function getDogs() {
			return $this->dogs;
		}

		public function setDogs($dogs) {
			$this->dogs = $dogs;
		}


		public function getIdOwner() {
			return $this->idOwner;
		}
		
		public function setIdOwner($idOwner){
			$this->idOwner = $idOwner;
		}
}

?>