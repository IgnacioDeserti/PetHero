<?php

    namespace DAO;

    use Models\Review as Review;

    class ReviewDAO{
        private $connection;
        private $tableName = "review";

        public function __construct(){
        }


        
        public function Add(Review $review)
        {
            $query = "CALL Review_Add(?,?,?,?,?)";

            $parameters["rating"] = $review->getRating();
            $parameters["observation"] = $review->getObservations();
            $parameters["idOwner"] = $review->getIdOwner();
            $parameters["idGuardian"] = $review->getIdGuardian();
            $parameters["idReservation"] = $review->getIdReservation();
            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }

        public function GetReviewsByGuardian($idGuardian)
        {
            $reviewList = array();

            $query = "SELECT * FROM ".$this->tableName;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, array(), QueryType::StoredProcedure);

            foreach($result as $row){
                if($row["idGuardian"] == $idGuardian){
                    $review = new Review();
                    $review->setRating($row["rating"]);
                    $review->setObservations($row["observation"]);
                    $review->setIdOwner($row["idOwner"]);
                    $review->setIdGuardian($row["idGuardian"]);
                    $review->setIdReservation($row["idReservation"]);
                    array_push($reviewList, $review);
                }
            }

            return $reviewList;
        }

        public function delete($id){
            $query = "CALL Review_Delete(?)";

            $parameters["id"] =  $id;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
        
}

?>