<?php

	namespace Models;
        
    abstract class Person{
        
    	private $name;
        private $address;
        private $email;
        private $number;
		private $userName;
		private $password;

	function __construct() {
	    
	}

	function getName() {
		return $this->name;
	}
	
	function setName($name) {
		$this->name = $name;
	}	

	function getAddress() {
		return $this->address;
	}
	
	function setAddress($address) {
		$this->address = $address;
	}
	
	function getEmail() {
		return $this->email;
	}
	
	function setEmail($email) {
		$this->email = $email;
	}
	
	function getNumber() {
		return $this->number;
	}
	
	function setNumber($number) {
		$this->number = $number;
	}
	
	public function getPassword() {
		return $this->password;
	}
	
	public function setPassword($password){
		$this->password = $password;
	}

	function getUserName(){
		return $this->userName;
	}

	function setUserName($userName){
		$this->userName = $userName;
	}
}

?>