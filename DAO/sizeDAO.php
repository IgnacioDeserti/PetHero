<?php

    namespace DAO;

use Models\Size;
use SimpleXMLElement;
    

    class sizeDAO{
        private $connection;
        private $tableName = "size";
        private $sizeList;

        public function __construct(){
            $this->sizeList = array();
        }

        public function getAll(){

            $query = "CALL Size_GetAll()";

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, array(), QueryType::StoredProcedure);

            foreach($result as $row){
                $newSize = new Size();
                $newSize->setIdSize($row['idSize']);
                $newSize->setName($row['name']);
                array_push($this->sizeList, $newSize);
            }

            return $this->sizeList;
        }

        public function getName ($idSize){

            $query = "CALL Size_GetName(?)";

            $this->connection = Connection::GetInstance();

            $parameters["idSizeS"] = $idSize;

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            foreach($result as $row){
                $name = $row['name'];
            }

            return $name;
        }
        
}

?>