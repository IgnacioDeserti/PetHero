<?php

    namespace DAO;

    use Models\Pet as Pet;
    use DAO\IPetDAO as IPetDAO;

    class PetDAO implements IPetDAO{

        private $PetList;
        private $fileName;

        public function __construct(){
            $this->fileName = dirname(__DIR__)."/Data/Pet.json";
        }


        public function add(Pet $newPet){
            $this->retrieveData();
            $newPet->setIdPet($this->getNextId());
            array_push($this->PetList, $newPet);
            $this->saveData();
        }

        public function getPetByID($id){
            $this->RetrieveData();

            foreach($this->PetList as $Pet){
                if($Pet->getId()==$id){
                    return $Pet;
                }
            }

            return null;
        }
        
        public function delete($id){
            $this->retrieveData();
        foreach($this->PetList as $index=>$item) 
        {
          if($item->getId() == $id)
          {
            unset($this->PetList[$index]);
            $this->SaveData();
            return true;
          }
        }
        return false;

        }

        public function getAll(){
            $this->retrieveData();
            return $this->PetList;
        }

        private function saveData(){
            $arrayToEncode = array();

            foreach($this->PetList as $Pet){
                    $value['idPet'] = $Pet->getIdPet();
                    $value['name'] = $Pet->getName();
                    $value['breed'] = $Pet->getBreed();
                    $value['size'] = $Pet->getSize();
                    $value['observations'] = $Pet->getObservations();
                    $value['photo1'] = $Pet->getPhoto1();
                    $value['photo2'] = $Pet->getPhoto2();
                    $value['video'] = $Pet->getVideo();
                    $value["idOwner"] = $Pet->getIdOwner();

                    array_push($arrayToEncode, $value);
                }

            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

            file_put_contents($this->GetJsonFilePath(), $jsonContent);
        } 

        private function retrieveData(){
            $this->PetList = array();

            if(file_exists($this->fileName)){
                $jsonContent = file_get_contents($this->GetJsonFilePath());

                $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach($arrayToDecode as $valuesArray){
                    $Pet = new Pet();
                    $Pet->setIdPet($valuesArray["idPet"]);
                    $Pet->setName($valuesArray["name"]);
                    $Pet->setBreed($valuesArray["breed"]);
                    $Pet->setSize($valuesArray["size"]);
                    $Pet->setObservations($valuesArray["observations"]);
                    $Pet->setPhoto1($valuesArray["photo1"]);
                    $Pet->setPhoto2($valuesArray["photo2"]);
                    $Pet->setVideo($valuesArray["video"]);
                    $Pet->setIdOwner($valuesArray["idOwner"]);

                    array_push($this->PetList, $Pet);
                }
            }
        }

        private function GetJsonFilePath(){

            $initialPath = "Data/Pet.json";
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
            
            foreach ($this->PetList as $Pet) 
            {
                $id= $Pet->getIdPet() > $id ? $Pet->getIdPet() : $id;
            }
    
            return $id+1;
        }




}

?>