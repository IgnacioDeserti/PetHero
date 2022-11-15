<?php

    namespace DAO;

    use Models\Owner as Owner;
    use DAO\IOwnersDAO;
    use DAO\PetDAO as PetDAO;
    use Exception;
    use Models\Pet as Pet;

    class ownersDAO implements IOwnersDAO{

        private $connection;
        private $tableName = "owner";

        public function __construct(){
        }

        public function Add(Owner $owner){            
            $query = "CALL Owner_Add(?, ?, ?, ?, ?, ?, ?)";
            $parameters["name"] =  $owner->getName();
            $parameters["address"] = $owner->getAddress();
            $parameters["email"] = $owner->getEmail();
            $parameters["number"] = $owner->getNumber();
            $parameters["userName"] = $owner->getUserName();
            $parameters["password"] = $owner->getPassword();
            $parameters["typeUser"] = $owner->getTypeUser();

            try{
                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
            }catch (Exception $error){
                throw $error;
            }
            
        }

        public function GetAll(){
            $ownerList = array();

            $query = "SELECT * FROM ".$this->tableName;

            try{
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
                    array_push($ownerList, $owner);
                }

                return $ownerList;
            }catch(Exception $error){
                throw $error;
            }
        }

        public function getNameById($id){
            
            $result = NULL;

            $parameter["idS"] = $id;

            $query = "CALL Owner_GetOwnerById(?)";

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameter, QueryType::StoredProcedure);

            return $result['name'];
        }

        public function getOwner($email){
            $result = NULL;

            $parameter["email"] = $email;

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
            }

            return $owner;
        }
        
        public function delete($id){
            $query = "CALL Owner_Delete(?)";

            $parameters["id"] =  $id;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);

        }

        public function getOwnerByUserName($userName){
            $result = NULL;

            $parameter["userName"] = $userName;

            $query = "CALL GetOwnerByUserName(?)";

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
            }

            return $owner;
        }
        
        public function GetIdOwner($email){
            $result = NULL;

            $parameter["email"] = $email;

            $query = "CALL Owner_GetIdOwner(?)";

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameter, QueryType::StoredProcedure);

            $owner = new Owner();
            foreach($result as $row){
                $owner->setIdOwner($row["idOwner"]);
            }

            return $owner;
        }
}

?>