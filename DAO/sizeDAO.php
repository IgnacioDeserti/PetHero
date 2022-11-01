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
            $searched = NULL;

            $query = "CALL SizeGetAll()";

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, array(), QueryType::StoredProcedure);

            $sizeList = array();
            foreach($result as $row){
                $newSize = new Size();
                $newSize->setIdSize($row['idSize']);
                $newSize->setName($row['name']);
                array_push($this->sizeList, $newSize);
            }

            return $this->sizeList;
        }
        
}

?>