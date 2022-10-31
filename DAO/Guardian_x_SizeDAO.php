<?php

    namespace DAO;

    class guardian_x_sizeDAO{
        private $connection;
        private $tableName = "guardian_x_size";

        public function __construct(){
        }


        
        public function Add($idGuardian, $idSize)
        {
            $query = "CALL guardian_x_size_Add(?, ?)";

            $parameters["idGuardian"] =  $idGuardian;
            $parameters["idSize"] = $idSize;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }


        public function getGuardian($idGuardian){

            $idSizeList = array();

            $query = "CALL Guardian_GetGuardian(?)";

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, array(), QueryType::StoredProcedure);

            foreach($result as $row){
                array_push($idSizeList, $row["idSize"]);
            }

            return $idSizeList;
        }
        
        public function delete($id){
            $query = "CALL Guardian_Delete(?)";

            $parameters["id"] =  $id;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);

        }

}

?>