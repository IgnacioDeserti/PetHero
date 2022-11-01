<?php
	namespace Models;

    class Pet {
		private $idPet;
        private $name;
        private $breed; //raza
        private $idSize;
        private $observations;
        private $photo1;
        private $photo2;
        private $video;
		private $idOwner;
		private $type;

        public function __construct(){
            
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

		public function getIdSize() {
			return $this->idSize;
		}
		
		public function setIdSize($idSize){
			$this->idSize = $idSize;
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

		function getIdPet() {
		return $this->idPet;
	    }
	

		function setIdPet($id): self {
			$this->idPet = $id;
			return $this;
		}

		function setType($type){
			$this->type = $type;
			return $this;
		}

		function getType(){
			return $this->type;
		}
}


?>