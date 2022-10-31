<?php

    namespace DAO;

    use Models\Size;
    

    class sizeDAO{
        private $connection;
        private $tableName = "size";

        public function __construct(){
        }

        public function getGuardian(Size $newSize){
            $searched = NULL;

            $sizeList = array();

            $query = "CALL Size_GetSize(?)";

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, array(), QueryType::StoredProcedure);

            foreach($result as $row){
                if(strcmp($row["idSize"], $newSize->getIdSize()) == 0){
                    $searched = $newSize;
                }
            }

            return $searched;
        }
        
}

?>