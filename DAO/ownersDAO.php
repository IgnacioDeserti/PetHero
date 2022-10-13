<?php

    namespace DAO;

    use Models\Owner as Owner;
    use DAO\IOwnersDAO;
    use Models\Dog as Dog;

    class ownersDAO implements IOwnersDAO{

        private $ownerList;
        private $fileName;

        public function __construct(){
            $this->fileName = dirname(__DIR__)."/Data/owners.json";
        }


        public function add(Owner $newOwner){
            $this->retrieveData();
            array_push($this->ownerList, $newOwner);
            $this->saveData();
        }
        
        public function delete($id){

        }

        public function getAll(){
            $this->retrieveData();
            return $this->ownerList;
        }

        public function getOwner(Owner $newOwner){
            $searched = NULL;

            foreach($this->ownerList as $list){
                if(strcmp($list->getEmail(), $newOwner->getEmail()) == 0){
                    $searched = $newOwner;
                }
            }

            return $searched;
        }

        private function saveData(){
            $arrayToEncode = array();

            foreach($this->ownerList as $owner){
                    $valuesArray["name"] = $owner->getName();
                    $valuesArray["address"] = $owner->getAddress();
                    $valuesArray["email"] = $owner->getEmail();
                    $valuesArray["number"] = $owner->getNumber();
                    $valuesArray["userName"] = $owner->getUserName();
                    $valuesArray["password"] = $owner->getPassword();
                    $aux = $owner->getDogs();
                    $arrayDogs = array();
                    foreach($aux as $dog){
                        $value['name'] = $dog->getName();
                        $value['breed'] = $dog->getBreed();
                        $value['size'] = $dog->getSize();
                        $value['observations'] = $dog->getObservations();
                        $value['photo1'] = $dog->getPhoto1();
                        $value['photo2'] = $dog->getPhoto2();
                        $value['video'] = $dog->getVideo();
                        array_push($arrayDogs, $value);
                    }
                    $valuesArray['dogs'] = $arrayDogs;
                    array_push($arrayToEncode, $valuesArray);
                }

            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

            file_put_contents($this->GetJsonFilePath(), $jsonContent);
        } 

        private function retrieveData(){
            $this->ownerList = array();

            if(file_exists($this->fileName)){
                $jsonContent = file_get_contents($this->GetJsonFilePath());

                $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach($arrayToDecode as $valuesArray){
                    $owner = new Owner();
                    $owner->setName($valuesArray["name"]);
                    $owner->setAddress($valuesArray["address"]);
                    $owner->setEmail($valuesArray["email"]);
                    $owner->setNumber($valuesArray["number"]);
                    $owner->setUserName($valuesArray["userName"]);
                    $owner->setPassword($valuesArray["password"]);
                    $aux = $valuesArray["dogs"];
                    $arrayDogs = array();
                    foreach($aux as $value){
                        $dog = new Dog();
                        $dog->setName($value['name']);
                        $dog->setBreed($value['breed']);
                        $dog->setSize($value['size']);
                        $dog->setObservations($value['observations']);
                        $dog->setPhoto1($value['photo1']);
                        $dog->setPhoto2($value['photo2']);
                        $dog->setVideo($value['video']);
                        array_push($arrayDogs, $dog);
                    }
                    $owner->setDogs($arrayDogs);
                    array_push($this->ownerList, $owner);
                }
            }
        }

        private function GetJsonFilePath(){

            $initialPath = "Data/owners.json";
            if(file_exists($initialPath)){
                $jsonFilePath = $initialPath;
            }else{
                $jsonFilePath = "../".$initialPath;
            }

            return $jsonFilePath;
        }
}

?>