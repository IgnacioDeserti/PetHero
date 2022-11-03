<?php

    namespace DAO;

    use Models\Reservation;

    class ReservationDAO{
        private $connection;
        private $tableName = "reservation";

        public function __construct(){
        }


        
        public function Add(Reservation $reservation)
        {
            $query = "CALL Reservation_Add(?,?,?,?,?,?,?)";

            $parameters["idOwner"] = $reservation->getIdOwner();
            $parameters["idGuardian"] = $reservation->getIdGuardian();
            $parameters["idPet"] = $reservation->getIdPet();
            $parameters["breed"] = $reservation->getBreed();
            $parameters["animalType"] = $reservation->getAnimalType();
            $parameters["reservationDateStart"] = $reservation->getReservationDateStart();
            $parameters["reservationDateEnd"] = $reservation->getReservationDateEnd();
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
                    $reservation = new Reservation();
                    $reservation->setIdReservation($row["idReservation"]);
                    $reservation->setIdOwner($row["idOwner"]);
                    $reservation->setIdGuardian($row["idGuardian"]);
                    $reservation->setIdPet($row["idPet"]);
                    $reservation->setBreed($row["breed"]);
                    $reservation->setAnimalType($row["animalType"]);
                    $reservation->setReservationDateStart($row["reservationDateStart"]);
                    $reservation->setReservationDateEnd($row["reservationDateEnd"]);
                    array_push($reviewList, $reservation);
                }
            }

            return $reviewList;
        }

        public function delete($id){
            $query = "CALL Reservation_Delete(?)";

            $parameters["id"] =  $id;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
        
}

?>