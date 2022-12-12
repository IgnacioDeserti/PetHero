<?php 

    namespace Models;

    class Message {
        
        private $idMessage;
        private $idOwner;
        private $idGuardian;
        private $content;
        private $fecha;
        private $sender;

        public function __construct () {

        }

        public function getIdMessage()
        {
                return $this->idMessage;
        }

        public function setIdMessage($idMessage)
        {
                $this->idMessage = $idMessage;

                return $this;
        }

        public function getIdOwner()
        {
                return $this->idOwner;
        }
 
        public function setIdOwner($idOwner)
        {
                $this->idOwner = $idOwner;

                return $this;
        }
 
        public function getIdGuardian()
        {
                return $this->idGuardian;
        }
 
        public function setIdGuardian($idGuardian)
        {
                $this->idGuardian = $idGuardian;

                return $this;
        }

        public function getContent()
        {
                return $this->content;
        }

        public function setContent($content)
        {
                $this->content = $content;

                return $this;
        }

        public function getFecha()
        {
                return $this->fecha;
        }

        public function setFecha($fecha)
        {
                $this->fecha = $fecha;

                return $this;
        }

 
        public function getSender()
        {
                return $this->sender;
        }

        public function setSender($sender)
        {
                $this->sender = $sender;

                return $this;
        }
    }




?>