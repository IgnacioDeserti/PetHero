<?php
	
	namespace Models;
	use Models\Person as Person;
	use Models\Pet;

    class Owner extends Person {
        private $Pets;
		private $idOwner;

		public function __construct() {
			parent::__construct();
			$this->Pets = array();
		}
	
		public function getPets() {
			return $this->Pets;
		}

		public function setPets($Pets) {
			$this->Pets = $Pets;
		}


		public function getIdOwner() {
			return $this->idOwner;
		}
		
		public function setIdOwner($idOwner){
			$this->idOwner = $idOwner;
		}
}

?>