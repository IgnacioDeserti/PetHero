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
            }catch(Exception $error){
                throw new Exception("No se pudo agregar dueño");
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
                throw new Exception("La lista de dueños esta vacia");
            }
        }

        public function getNameById($id){
            
            $result = NULL;

            $parameter["idO"] = $id;

            $query = "CALL Owner_GetNameOwnerById(?)";

            try{
                $this->connection = Connection::GetInstance();
                $result = $this->connection->Execute($query, $parameter, QueryType::StoredProcedure);

                foreach($result as $row){
                    $name = $row["name"];
                }
                return $name;
            }catch(Exception $error){
                throw new Exception("No existe dueño con ese id");
            }
        }

        public function getOwner($email){
            $result = NULL;

            $parameter["email"] = $email;

            $query = "CALL Owner_GetOwner(?)";

            try{
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

            }catch(Exception $error){
                throw new Exception("No se pudo agregar dueño");
            }
        }
        
        public function delete($id){
            $query = "CALL Owner_Delete(?)";

            $parameters["id"] =  $id;

            try{
                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
            }catch(Exception $error){
                throw new Exception("No se pudo agregar dueño");
            }

        }

        public function getOwnerByUserName($userName){
            $result = NULL;

            $parameter["userName"] = $userName;

            $query = "CALL GetOwnerByUserName(?)";

            try{
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
            }catch(Exception $error){
                throw new Exception("No se pudo agregar dueño");
            }
        }
        
        public function GetIdOwner($email){
            $result = NULL;

            $parameter["email"] = $email;

            $query = "CALL Owner_GetIdOwner(?)";

            try{
                $this->connection = Connection::GetInstance();
                $result = $this->connection->Execute($query, $parameter, QueryType::StoredProcedure);

                $owner = new Owner();
                foreach($result as $row){
                    $owner->setIdOwner($row["idOwner"]);
                }

                return $owner;
            }catch(Exception $error) {
                throw $error;
            }
        }
}

?>