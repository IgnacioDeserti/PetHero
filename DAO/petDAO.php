<?php

    namespace DAO;

    use Models\Pet as Pet;
    use DAO\IPetDAO;
    use Exception;

    class PetDAO implements IPetDAO{
        private $connection;
        private $tableName = "pet";

        
        public function __construct(){
        }
        
        public function Add(Pet $pet)
        {
            $query = "CALL Pet_Add(?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $parameters["name"] = $pet->getName();
            $parameters["breed"] = $pet->getBreed();
            $parameters["idSize"] = $pet->getIdSize();
            $parameters["observations"] = $pet->getObservations();
            $parameters["photo1"] = $pet->getPhoto1();
            $parameters["photo2"] = $pet->getPhoto2();
            $parameters["video"] = $pet->getVideo();
            $parameters["idOwner"] = $pet->getIdOwner();
            $parameters["type"] = $pet->getType();

            try{
                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
            }catch(Exception $error){
                throw new Exception("No se pudo agregar mascota");
            }

        }

        public function GetPetByIdOwner($idOwner)
        {
            $petList = array();

            $parameters["idO"] = $idOwner;

            $query = "CALL Pet_GetPetByIdOwner(?)";

            try{
                $this->connection = Connection::GetInstance();
                $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
                foreach($result as $row){
                    $pet = new Pet();
                    $pet->setIdPet($row["idPet"]);
                    $pet->setName($row["name"]);
                    $pet->setBreed($row["breed"]);
                    $pet->setIdSize($row["idSize"]);
                    $pet->setObservations($row["observations"]);
                    $pet->setPhoto1($row["photo1"]);
                    $pet->setPhoto2($row["photo2"]);
                    $pet->setVideo($row["video"]);
                    $pet->setIdOwner($row["idOwner"]);
                    $pet->setType($row["type"]);
                    array_push($petList, $pet);
                }

                return $petList;
            }catch(Exception $error){
                throw new Exception("El dueño con ese id no tiene mascotas");
            }
        }

        public function GetAll()
        {
            $petList = array();

            $query = "SELECT * FROM ".$this->tableName;

            try{
                $this->connection = Connection::GetInstance();

                $result = $this->connection->Execute($query, array(), QueryType::StoredProcedure);

                foreach($result as $row){
                    $pet = new Pet();
                    $pet->setName($row["name"]);
                    $pet->setBreed($row["breed"]);
                    $pet->setIdSize($row["idSize"]);
                    $pet->setObservations($row["observations"]);
                    $pet->setPhoto1($row["photo1"]);
                    $pet->setPhoto2($row["photo2"]);
                    $pet->setVideo($row["video"]);
                    $pet->setIdOwner($row["idOwner"]);
                    $pet->setType($row["type"]);
                    array_push($petList, $pet);
                }

                return $petList;
            }catch(Exception $error){
                throw new Exception("La lista de mascotas esta vacia");
            }
        }

        public function getPetByIdPet($idPet)
        {
            $query = "CALL Pet_getPetById(?)";

            $parameters["idPetS"] = $idPet;

            try{
                $this->connection = Connection::GetInstance();

                $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

                foreach($result as $row){
                    $pet = new Pet();
                    $pet->setName($row["name"]);
                    $pet->setBreed($row["breed"]);
                    $pet->setIdSize($row["idSize"]);
                    $pet->setObservations($row["observations"]);
                    $pet->setPhoto1($row["photo1"]);
                    $pet->setPhoto2($row["photo2"]);
                    $pet->setVideo($row["video"]);
                    $pet->setIdOwner($row["idOwner"]);
                    $pet->setType($row["type"]);
                }

                return $pet;
            }catch(Exception $error){
                throw new Exception("No se pudo eliminar mascota");
            }
        }

        public function delete($id){
            $query = "CALL Dog_Delete(?)";

            $parameters["id"] =  $id;

            try{
                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
            }catch(Exception $error){
                throw new Exception("No se pudo eliminar mascota");
            }
        }

        public function getNameByIdPet($idPet)
        {
            $query = "CALL Pet_GetNameByIdPet(?)";

            $parameters["idPetS"] = $idPet;

            try{
                $this->connection = Connection::GetInstance();
                $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

                foreach($result as $row){
                    $pet = new Pet();
                    $pet->setName($row["name"]);
                }

                return $pet->getName();
            }catch(Exception $error){
                throw new Exception("No existe mascota con ese id");
            }
        }

        public function deletePet ($idPet){
            $query = "CALL pet_deletePet(?)";

            $parameters["idPetS"] = $idPet;

            try{
                $this->connection = Connection::GetInstance();
                $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
            }catch(Exception $error){
                throw new Exception("No se pudo dar de baja a la mascota");
            }
        }

}
/*      private $dogList;
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
                $id= $dog->getIdDog() > $id ? $dog->getIdDog() : $id;
            }
    
            return $id+1;
        }

*/

?>