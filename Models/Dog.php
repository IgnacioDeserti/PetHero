<?php
	namespace Models;

    class Dog {
        private $name;
        private $breed; //raza
        private $size;
        private $observations;
        private $photo1;
        private $photo2;
        private $video;


        private function __construct(){
            
        }

	function getName() {
		return $this->name;
	}
	
	function setName($name) {
		$this->name = $name;
	}

	function getBreed() {
		return $this->breed;
	}
	
	function setBreed($breed) {
		$this->breed = $breed;
	}

	function getSize() {
		return $this->size;
	}
	
	function setSize($size){
		$this->size = $size;
	}

	function getObservations() {
		return $this->observations;
	}
	
	function setObservations($observations) {
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
}


?>