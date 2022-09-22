<?php
    class Dog {
        private $name;
        private $breed; //raza
        private $size;
        private $observations;
        private $photo1;
        private $photo2;
        private $video;


        private function __construct($name, $breed, $size, $observations){
            $this->name = $name;
            $this->breed = $breed;
            $this->size = $size;
            $this->observations = $observations;
        }

	function getName() {
		return $this->name;
	}
	
	function setName($name) {
		$this->name = $name;
		return $this;
	}

	function getBreed() {
		return $this->breed;
	}
	
	function setBreed($breed) {
		$this->breed = $breed;
		return $this;
	}

	function getSize() {
		return $this->size;
	}
	
	function setSize($size){
		$this->size = $size;
		return $this;
	}

	function getObservations() {
		return $this->observations;
	}
	
	function setObservations($observations) {
		$this->observations = $observations;
		return $this;
	}
}


?>