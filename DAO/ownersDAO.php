<?php

    namespace DAO;

    use Models\Owner as Owner;
    use DAO\IOwnersDAO;
    use DAO\dogDAO as DogDAO;
    use Models\Dog as Dog;

    class ownersDAO implements IOwnersDAO{

        private $ownerList;
        private $fileName;
        private $dogDAO;

        public function __construct(){
            $this->fileName = dirname(__DIR__)."/Data/owners.json";
            $this->dogDAO = new DogDAO();
        }


        public function add(Owner $newOwner){
            $this->retrieveData();
            $newOwner->setIdOwner($this->setId());
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
                        $value = $dog->getId();
                        array_push($arrayDogs, $value);
                    }
                    $valuesArray['dogs'] = $arrayDogs;
                    $valuesArray["idOwner"] = $owner->getIdOwner();
                    $valuesArray["typeUser"] = $owner->getTypeUser();
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
                        $dog = $this->dogDAO->getDogById($value);
                        array_push($arrayDogs, $dog);
                    }
                    $owner->setIdOwner($valuesArray["idOwner"]);
                    $owner->setTypeUser($valuesArray["typeUser"]);
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

        private function setId(){
            return count($this->getAll()) + 1;
        }
}

?>