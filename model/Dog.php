<?php

    class Dog{
        private $name;
        private $breed; //raza
        private $size;
        private $observations;


        private function __construct($name, $breed, $size, $observations){
            $this->name = $name;
            $this->breed = $breed;
            $this->size = $size;
            $this->observations = $observations;
        }
    }


?>