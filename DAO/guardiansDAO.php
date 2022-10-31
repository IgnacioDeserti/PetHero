<?php

    namespace DAO;

    use Models\Guardian as Guardian;
    use DAO\IGuardiansDAO as IGuardiansDAO;
    use Models\Review as Review;

    class guardiansDAO implements IGuardiansDAO{
        private $connection;
        private $tableName = "guardian";

        public function __construct(){
        }


        
        public function Add(Guardian $guardian)
        {
            $query = "CALL Guardian_Add(?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $parameters["name"] =  $guardian->getName();
            $parameters["address"] = $guardian->getAddress();
            $parameters["email"] = $guardian->getEmail();
            $parameters["number"] = $guardian->getNumber();
            $parameters["userName"] = $guardian->getUserName();
            $parameters["password"] = $guardian->getPassword();
            $parameters["typeUser"] = $guardian->getTypeUser();
            $parameters["availabilityStart"] = $guardian->getAvailabilityStart();
            $parameters["availabilityEnd"] = $guardian->getAvailabilityEnd();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }

        public function GetAll()
        {
            $guardianList = array();

            $query = "SELECT * FROM ".$this->tableName;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, array(), QueryType::StoredProcedure);

            foreach($result as $row){
                $guardian = new Guardian();
                $guardian->setIdGuardian($row["idGuardian"]);
                $guardian->setName($row["name"]);
                $guardian->setAddress($row["address"]);
                $guardian->setEmail($row["email"]);
                $guardian->setNumber($row["number"]);
                $guardian->setUserName($row["userName"]);
                $guardian->setPassword($row["password"]);
                $guardian->setTypeUser($row["typeUser"]);
                $guardian->setAvailabilityStart($row["availabilityStart"]);
                $guardian->setAvailabilityEnd($row["availabilityEnd"]);
                array_push($guardianList, $guardian);
            }

            return $guardianList;
        }


        public function getGuardian(Guardian $newGuardian){
            $result = NULL;

            $parameter["idGuardian"] = $newGuardian->getEmail();

            $query = "CALL Guardian_GetGuardian(?)";

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameter, QueryType::StoredProcedure);

            $guardian = new Guardian();
            foreach($result as $row){
                $guardian->setIdGuardian($row["idGuardian"]);
                $guardian->setName($row["name"]);
                $guardian->setAddress($row["address"]);
                $guardian->setEmail($row["email"]);
                $guardian->setNumber($row["number"]);
                $guardian->setUserName($row["userName"]);
                $guardian->setPassword($row["password"]);
                $guardian->setTypeUser($row["typeUser"]);
                $guardian->setAvailabilityStart($row["availabilityStart"]);
                $guardian->setAvailabilityEnd($row["availabilityEnd"]);
            }
            

            return $guardian;
        }
        
        public function delete($id){
            $query = "CALL Guardian_Delete(?)";

            $parameters["id"] =  $id;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);

        }

        private function setId(){
            return count($this->getAll()) + 1;
        }

        public function UpdateAvailability($id, $date1, $date2){
            foreach($this->getAll() as $guardian){
                if($guardian->getIdGuardian() == $id){
                    $guardian->setAvailabilityStart($date1);
                    $guardian->setAvailabilityEnd($date2);
                }
                
            }
        }
}

?>