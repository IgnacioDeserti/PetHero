<?php
	
	namespace Models;
	use Models\Person as Person;

    class Guardian extends Person{
        private $availabilityStart;
		private $availabilityEnd;
		private $idGuardian;

		public function __construct(){
			parent::__construct();
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
	
		public function getIdGuardian(){
			return $this->idGuardian;
		}

		public function setIdGuardian($idGuardian){
			$this->idGuardian = $idGuardian;
		}
}

?>