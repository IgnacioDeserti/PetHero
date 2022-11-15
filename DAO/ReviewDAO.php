<?php

    namespace DAO;

    use Models\Review as Review;
    use Exception;

    class ReviewDAO{
        private $connection;
        private $tableName = "review";

        public function __construct(){
        }


        
        public function Add(Review $review)
        {
            $query = "CALL Review_Add(?,?,?,?,?)";

            $parameters["rating"] = $review->getRating();
            $parameters["observations"] = $review->getObservations();
            $parameters["idOwner"] = $review->getIdOwner();
            $parameters["idGuardian"] = $review->getIdGuardian();
            $parameters["idReservation"] = $review->getIdReservation();
            
            try{
                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
            }catch(Exception $error){
                throw new Exception("No se pudo agregar la reseña");
            }
        }

        public function GetReviewsByGuardian($idGuardian)
        {
            $reviewList = array();

            $query = "CALL Review_GetReviewsByGuardian(?)";

            $parameters["idGuardianS"] = $idGuardian;

            try{
                $this->connection = Connection::GetInstance();

                $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

                foreach($result as $row){
                    $review = new Review();
                    $review->setRating($row["rating"]);
                    $review->setObservations($row["observations"]);
                    $review->setIdOwner($row["idOwner"]);
                    $review->setIdGuardian($row["idGuardian"]);
                    $review->setIdReservation($row["idReservation"]);
                    array_push($reviewList, $review);
                }

                return $reviewList;
            }catch(Exception $error){
                throw new Exception("El guardian con ese id no tiene reseñas");
            }
        }

        public function delete($id){
            $query = "CALL Review_Delete(?)";

            $parameters["id"] =  $id;

            try{
                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
            }catch(Exception $error){
                throw new Exception("No se pudo eliminar la reseña");
            }
        }
        

        
}

?>