<?php

	namespace Models;
        
    abstract class Person{
        
    	private $name;
        private $address;
        private $email;
        private $number;
		private $userName;
		private $password;
		private $typeUser;

		public function __construct() {
			
		}

		public function getName(){
			return $this->name;
		}
		
		public function setName($name){
			$this->name = $name;
		}	

		public function getAddress(){
			return $this->address;
		}
		
		public function setAddress($address){
			$this->address = $address;
		}
		
		public function getEmail(){
			return $this->email;
		}
		
		public function setEmail($email){
			$this->email = $email;
		}
		
		public function getNumber(){
			return $this->number;
		}
		
		public function setNumber($number){
			$this->number = $number;
		}
		
		public function getPassword(){
			return $this->password;
		}
		
		public function setPassword($password){
			$this->password = $password;
		}

		public function getUserName(){
			return $this->userName;
		}

		public function setUserName($userName){
			$this->userName = $userName;
		}
		
		public function setTypeUser($typeUser){
			$this->typeUser = $typeUser;
		}

		public function getTypeUser() {
			return $this->typeUser;
		}
}

?>