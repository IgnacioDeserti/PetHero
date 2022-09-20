<?php

    class Owner{

        private $name;
        private $address;
        private $id; //DNI
        private $dogs; //ARRAY DE DOGS??
        private $number;

        private function __construct($name, $address, $id, $dogs, $number){
            $this->name = $name;
            $this->address = $address;
            $this->id = $id;
            $this->dogs = $dogs;
            $this->number = $number;
        }
    

    }


?>