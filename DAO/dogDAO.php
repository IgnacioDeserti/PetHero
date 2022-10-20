<?php

    namespace DAO;

    use Models\Dog as Dog;
    use DAO\IDogDAO as IDogDAO;

    class dogDAO implements IDogDAO{

        private $dogList;
        private $fileName;

        public function __construct(){
            $this->fileName = dirname(__DIR__)."/Data/dog.json";
        }


        public function add(Dog $newDog){
            $this->retrieveData();
            $newDog->setIdDog($this->getNextId());
            array_push($this->dogList, $newDog);
            $this->saveData();
        }

        public function getDogByID($id){
            $this->RetrieveData();

            foreach($this->dogList as $dog){
                if($dog->getId()==$id){
                    return $dog;
                }
            }

            return null;
        }
        
        public function delete($id){
            $this->retrieveData();
        foreach($this->dogList as $index=>$item) 
        {
          if($item->getId() == $id)
          {
            unset($this->dogList[$index]);
            $this->SaveData();
            return true;
          }
        }
        return false;

        }

        public function getAll(){
            $this->retrieveData();
            return $this->dogList;
        }

        private function saveData(){
            $arrayToEncode = array();

            foreach($this->dogList as $dog){
                    $value['idDog'] = $dog->getIdDog();
                    $value['name'] = $dog->getName();
                    $value['breed'] = $dog->getBreed();
                    $value['size'] = $dog->getSize();
                    $value['observations'] = $dog->getObservations();
                    $value['photo1'] = $dog->getPhoto1();
                    $value['photo2'] = $dog->getPhoto2();
                    $value['video'] = $dog->getVideo();
                    $value["idOwner"] = $dog->getIdOwner();

                    array_push($arrayToEncode, $value);
                }

            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

            file_put_contents($this->GetJsonFilePath(), $jsonContent);
        } 

        private function retrieveData(){
            $this->dogList = array();

            if(file_exists($this->fileName)){
                $jsonContent = file_get_contents($this->GetJsonFilePath());

                $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach($arrayToDecode as $valuesArray){
                    $dog = new Dog();
                    $dog->setIdDog($valuesArray["idDog"]);
                    $dog->setName($valuesArray["name"]);
                    $dog->setBreed($valuesArray["breed"]);
                    $dog->setSize($valuesArray["size"]);
                    $dog->setObservations($valuesArray["observations"]);
                    $dog->setPhoto1($valuesArray["photo1"]);
                    $dog->setPhoto2($valuesArray["photo2"]);
                    $dog->setVideo($valuesArray["video"]);
                    $dog->setIdOwner($valuesArray["idOwner"]);

                    array_push($this->dogList, $dog);
                }
            }
        }

        private function GetJsonFilePath(){

            $initialPath = "Data/dog.json";
            if(file_exists($initialPath)){
                $jsonFilePath = $initialPath;
            }else{
                $jsonFilePath = "../".$initialPath;
            }

            return $jsonFilePath;
        }

        private function getNextId(){
            $this->RetrieveData();
            $id=0;
            
            foreach ($this->dogList as $dog) 
            {
                $id= $dog->getId() > $id ? $dog->getId() : $id;
            }
    
            return $id+1;
        }




}

?>