<?php

    class Guardian{
        private $name;
        private $address;
        private $cuil;
        private $availability;

        private function __construct($name, $address, $cuil, $availability){
            $this->name = $name;
            $this->address = $address;
            $this->cuil = $cuil;
            $this->availability = $availability;
        }
    }

?>