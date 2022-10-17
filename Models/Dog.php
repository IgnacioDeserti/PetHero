<?php
	namespace Models;

    class Dog {
		private $idDog;
        private $name;
        private $breed; //raza
        private $size;
        private $observations;
        private $photo1;
        private $photo2;
        private $video;
		private $idOwner;


        private function __construct(){
            
        }

		public function getName() {
			return $this->name;
		}
		
		public function setName($name) {
			$this->name = $name;
		}

		public function getBreed() {
			return $this->breed;
		}
		
		public function setBreed($breed) {
			$this->breed = $breed;
		}

		public function getSize() {
			return $this->size;
		}
		
		public function setSize($size){
			$this->size = $size;
		}

		public function getObservations() {
			return $this->observations;
		}
		
		public function setObservations($observations) {
			$this->observations = $observations;
		}
		
		public function getPhoto1() {
			return $this->photo1;
		}
		
		public function setPhoto1($photo1) {
			$this->photo1 = $photo1;
		}
		
		public function getPhoto2() {
			return $this->photo2;
		}

		public function setPhoto2($photo2) {
			$this->photo2 = $photo2;
		}

		public function getVideo() {
			return $this->video;
		}
		
		public function setVideo($video) {
			$this->video = $video;
		}
		
		public function getIdOwner() {
			return $this->idOwner;
		}

		public function setIdOwner($idOwner){
			$this->idOwner = $idOwner;
		}

		function getIdDog() {
		return $this->idDog;
	}
	

	function setIdDog($id): self {
		$this->idDog = $id;
		return $this;
	}
}


?>