<?php

    namespace DAO;

    use Models\Pet as Pet;
    use DAO\IPetDAO;

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

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);

        }

        public function GetPetByIdOwner($idOwner)
        {
            $petList = array();

            $query = "SELECT * FROM ".$this->tableName;

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
        }

        public function GetAll()
        {
            $petList = array();

            $query = "SELECT * FROM ".$this->tableName;

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
        }

        public function getPetByIdPet($idPet)
        {
            $query = "CALL Pet_getPetById(?)";

            $parameters["idPetS"] = $idPet;

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
        }

        public function delete($id){
            $query = "CALL Dog_Delete(?)";

            $parameters["id"] =  $id;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
}

?>