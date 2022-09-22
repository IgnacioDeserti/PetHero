<?php
        
        abstract class Person{
        
        private $name;
        private $address;
        private $email;
        private $number;

	function __construct($name = null, $address = null, $email = null, $number = null) {
	    $this->name = $name;
	    $this->address = $address;
	    $this->email = $email;
	    $this->number = $number;
	}

	function getName() {
		return $this->name;
	}
	
	function setName($name) {
		$this->name = $name;
		return $this;
	}	

	function getAddress() {
		return $this->address;
	}
	
	function setAddress($address) {
		$this->address = $address;
		return $this;
	}
	
	function getEmail() {
		return $this->email;
	}
	
	function setEmail($email) {
		$this->email = $email;
		return $this;
	}
	
	function getNumber() {
		return $this->number;
	}
	
	function setNumber($number) {
		$this->number = $number;
		return $this;
	}
}

?>