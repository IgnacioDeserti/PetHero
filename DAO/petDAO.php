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

            $query = "SELECT * FROM ".$this->tableName;

            try{
                $this->connection = Connection::GetInstance();

                $result = $this->connection->Execute($query, array(), QueryType::StoredProcedure);

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

}

?>