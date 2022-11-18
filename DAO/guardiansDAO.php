<?php

    namespace DAO;

    use Models\Guardian as Guardian;
    use DAO\IGuardiansDAO as IGuardiansDAO;
use DateTime;
use Exception;
use Models\Review as Review;

    class guardiansDAO implements IGuardiansDAO{
        private $connection;
        private $tableName = "guardian";

        public function __construct(){
        }


        
        public function Add(Guardian $guardian)
        {
            $query = "CALL Guardian_Add(?, ?, ?, ?, ?, ?, ?, ?, ?,?)";

            $parameters["name"] =  $guardian->getName();
            $parameters["address"] = $guardian->getAddress();
            $parameters["email"] = $guardian->getEmail();
            $parameters["number"] = $guardian->getNumber();
            $parameters["userName"] = $guardian->getUserName();
            $parameters["password"] = $guardian->getPassword();
            $parameters["typeUser"] = $guardian->getTypeUser();
            $parameters["availabilityStart"] = $guardian->getAvailabilityStart();
            $parameters["availabilityEnd"] = $guardian->getAvailabilityEnd();
            $parameters["price"] = $guardian->getPrice();

            try{
                $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
                $this->connection = Connection::GetInstance();
            }catch(Exception $error){
                throw new Exception("No se pudo agregar el guardian");
            }
        }

        public function GetAll()
        {
            $guardianList = array();

            $query = "SELECT * FROM ".$this->tableName;

            try{
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
                    $guardian->setPrice($row['price']);
                    array_push($guardianList, $guardian);
                }

                return $guardianList;
            }catch(Exception $error){
                throw new Exception("Los guardianes estan de vacaciones :)");
            }
        }


        public function getGuardian($email){
            $result = NULL;

            $parameter["email"] = $email;

            $query = "CALL Guardian_GetGuardian(?)";

            try{
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
            }catch(Exception $error){
                throw new Exception("No existe guardian con ese mail");
            }
        }
        
        public function delete($id){
            $query = "CALL Guardian_Delete(?)";

            $parameters["id"] =  $id;

            try{
                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
            }catch(Exception $error){
                throw new Exception("No existe guardian con ese id");
            }

        }

        public function UpdateAvailabilityStart($id, $date){
            $query = "CALL Update_AvailabilityStart_Guardian(?, ?)";

            $parameters["newAvailabilityStart"] = $date;
            $parameters["idGuardianLogged"] =  $id;

            try{
                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
            }catch(Exception $error){
                throw new Exception("No hay guardian con ese id");
            }
        }

        public function UpdateAvailabilityEnd($id, $date){
            $query = "CALL Update_AvailabilityEnd_Guardian(?, ?)";

            $parameters["newAvailabilityEnd"] = $date;
            $parameters["idGuardianLogged"] =  $id;

            try{
                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
            }catch(Exception $error){
                throw new Exception("No hay guardian con ese id");
            }
        }

        
        public function getGuardianByUserName($userName){
            $result = NULL;

            $parameter["userName"] = $userName;

            $query = "CALL GetGuardianByUserName(?)";


            try{
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
            }catch(Exception $error){
                throw new Exception("No hay guardian con ese id");
            }
        }

        public function getReservationStart($idGuardian){  
            $result = NULL;

            $parameter["idGuardianS"] = $idGuardian;

            $query = "CALL Guardian_GetAvailabilityStart(?)";

            try{
                $this->connection = Connection::GetInstance();

                $result = $this->connection->Execute($query, $parameter, QueryType::StoredProcedure);

                $avStart = null;
                foreach($result as $row){
                    $avStart = new DateTime();
                    $avStart = $row["availabilityStart"];
                }
        
                return $avStart;
            }catch(Exception $error){
                throw new Exception("El guardian no tiene fechas asignadas");
            }
        }

        public function getReservationEnd($idGuardian){
            $result = NULL;
            $parameter["idGuardianS"] = $idGuardian;
            $query = "CALL Guardian_GetAvailabilityEnd(?)";

            try{
                $this->connection = Connection::GetInstance();
                $result = $this->connection->Execute($query, $parameter, QueryType::StoredProcedure);

                foreach($result as $row){
                    $avEnd = $row["availabilityEnd"];
                }
                return $avEnd;
            }catch(Exception $error){
                throw new Exception("No hay guardian con ese id");
            }
        }

        public function getGuardianById($idGuardian){
            $result = NULL;

            $parameter["idG"] = $idGuardian;

            $query = "CALL Guardian_GetGuardianById(?)";

            try{
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
                    $guardian->setPrice($row["price"]);
                }
            
                return $guardian;
            }catch(Exception $error){
                throw new Exception("No hay guardian con ese id");
            }
        }

}

?>