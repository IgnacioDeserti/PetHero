<?php

    namespace DAO;

    use Models\Guardian_x_Size;
    use DAO\sizeDAO;

    class guardian_x_sizeDAO{
        private $connection;
        private $tableName = "guardian_x_size";
        private $guardianXsizeList;

        public function __construct(){
            $this->guardianXsizeList = array();
        }


        
        public function Add($idGuardian, $idSize)
        {
            $query = "CALL guardian_x_size_Add(?, ?)";

            $parameters["idGuardian"] =  $idGuardian;
            $parameters["idSize"] = $idSize;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }

        public function getAll(){
            $searched = NULL;

            $query = "CALL Guardian_x_SizeGetAll()";

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, array(), QueryType::StoredProcedure);

            foreach($result as $row){
                $newGXS = new Guardian_x_Size();
                $newGXS->setIdGuardianxSize($row["idGuardianxSize"]);
                $newGXS->setIdGuardian($row["idGuardian"]);
                $newGXS->setIdSize($row["idSize"]);
                array_push($this->guardianXsizeList, $newGXS);
            }

            return $this->guardianXsizeList;
        }

        public function getSizeById($idGuardian){

            $SizeList = array();
            $sizeDAO = new  sizeDAO();

            $query = "CALL guardian_x_size_GetSizeByIdGuardian (?)";

            $parameters["idGuardianS"] =  $idGuardian;
            
            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, array(), QueryType::StoredProcedure);

            foreach($result as $row){
                array_push($SizeList, $sizeDAO->getName($row['idSize']));
            }

            return $SizeList;
        }
        
        public function delete($id){
            $query = "CALL Guardian_Delete(?)";

            $parameters["id"] =  $id;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);

        }

}

?>