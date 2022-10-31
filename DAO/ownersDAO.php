<?php

    namespace DAO;

    use Models\Owner as Owner;
    use DAO\IOwnersDAO;
    use DAO\PetDAO as PetDAO;
    use Models\Pet as Pet;

    class ownersDAO implements IOwnersDAO{

        private $connection;
        private $tableName = "owner";

        public function __construct(){
        }

        public function Add(Owner $owner)
        {
            $query = "CALL Owner_Add(?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $parameters["name"] =  $owner->getName();
            $parameters["address"] = $owner->getAddress();
            $parameters["email"] = $owner->getEmail();
            $parameters["number"] = $owner->getNumber();
            $parameters["userName"] = $owner->getUserName();
            $parameters["password"] = $owner->getPassword();
            $parameters["typeUser"] = $owner->getTypeUser();
            $parameters["pets"] = $owner->getPets();
            $parameters["idOwner"] = $owner->getIdOwner();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }

        public function GetAll()
        {
            $ownerList = array();

            $query = "SELECT * FROM ".$this->tableName;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, array(), QueryType::StoredProcedure);

            foreach($result as $row){
                $owner = new Owner();
                $owner->setIdOwner($row["idOwner"]);
                $owner->setName($row["name"]);
                $owner->setAddress($row["address"]);
                $owner->setEmail($row["email"]);
                $owner->setNumber($row["number"]);
                $owner->setUserName($row["userName"]);
                $owner->setPassword($row["password"]);
                $owner->setTypeUser($row["typeUser"]);
                $owner->setPets($row["pets"]);
                $owner->setIdOwner($row["idOwner"]);
                array_push($ownerList, $owner);
            }

            return $ownerList;
        }


        public function getOwner(owner $newowner){
            $result = NULL;

            $parameter["idOwner"] = $newowner->getEmail();

            $query = "CALL Owner_GetOwner(?)";

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameter, QueryType::StoredProcedure);

            $owner = new Owner();
            foreach($result as $row){
                $owner->setIdOwner($row["idOwner"]);
                $owner->setName($row["name"]);
                $owner->setAddress($row["address"]);
                $owner->setEmail($row["email"]);
                $owner->setNumber($row["number"]);
                $owner->setUserName($row["userName"]);
                $owner->setPassword($row["password"]);
                $owner->setTypeUser($row["typeUser"]);
                $owner->setPets($row["pets"]);
                $owner->setIdOwner($row["idOwner"]);
            }
            

            return $owner;
        }
        
        public function delete($id){
            $query = "CALL Owner_Delete(?)";

            $parameters["id"] =  $id;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);

        }

        private function setId(){
            return count($this->getAll()) + 1;
        }
}

?>