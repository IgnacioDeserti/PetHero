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
            $query = "CALL Reservation_Add(?,?,?,?,?,?,?,?)";

            $parameters["idOwner"] = $reservation->getIdOwner();
            $parameters["idGuardian"] = $reservation->getIdGuardian();
            $parameters["idPet"] = $reservation->getIdPet();
            $parameters["breed"] = $reservation->getBreed();
            $parameters["animalType"] = $reservation->getAnimalType();
            $parameters["size"] = $reservation->getSize();
            $parameters["reservationDateStart"] = $reservation->getReservationDateStart();
            $parameters["reservationDateEnd"] = $reservation->getReservationDateEnd();
            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }

        public function GetReservationsByGuardian($idGuardian)
        {
            $reservationList = array();

            $query = "CALL Reservation_GetReservationsByIdGuardian(?)";

            $parameters["idGuardianS"] = $idGuardian;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            foreach($result as $row){
                $reservation = new Reservation();
                    $reservation->setIdReservation($row["idReservation"]);
                    $reservation->setIdOwner($row["idOwner"]);
                    $reservation->setIdGuardian($row["idGuardian"]);
                    $reservation->setIdPet($row["idPet"]);
                    $reservation->setBreed($row["breed"]);
                    $reservation->setAnimalType($row["animalType"]);
                    $reservation->setReservationDateStart($row["reservationDateStart"]);
                    $reservation->setReservationDateEnd($row["reservationDateEnd"]);
                    $reservation->setReservationStatus($row["reservationStatus"]);
                    array_push($reservationList, $reservation);
            }

            return $reservationList;
        }

        public function GetReservationsByOwner($idOwner)
        {
            $reviewList = array();

            $query = "CALL Reservation_GetReservationsByIdOwner(?)";

            $parameters["idOwnerS"] = $idOwner;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            foreach($result as $row){
                    $reservation = new Reservation();
                    $reservation->setIdReservation($row["idReservation"]);
                    $reservation->setIdOwner($row["idOwner"]);
                    $reservation->setIdGuardian($row["idGuardian"]);
                    $reservation->setIdPet($row["idPet"]);
                    $reservation->setBreed($row["breed"]);
                    $reservation->setAnimalType($row["animalType"]);
                    $reservation->setReservationDateStart($row["reservationDateStart"]);
                    $reservation->setReservationDateEnd($row["reservationDateEnd"]);
                    $reservation->setReservationStatus($row["reservationStatus"]);
                    array_push($reviewList, $reservation);
            }

            return $reviewList;
        }

        

        public function delete($id){
            $query = "CALL Reservation_Delete(?)";

            $parameters["id"] =  $id;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }

        public function GetReservationDates($idGuardian)
        {
            $dates = array();

            $query = "CALL Reservation_GetReservationsByIdOwner(?)";

            $parameters["idGuardianS"] = $idGuardian;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, array(), QueryType::StoredProcedure);

            foreach($result as $date){
                array_push($dates, $date['availabilityStart']);
                array_push($dates, $date['availabilityEnd']);
                array_push($dates, $date['breed']);
                array_push($dates, $date['type']);
                array_push($dates, $date['size']);
            }

            return $dates;
        }

        public function changeReservationStatus ($idReservation,$status){
            $query = "CALL Reservation_changeStatus(?,?)";

            $parameters["idReservationS"] = $idReservation;
            $parameters["statusS"] = $status;

            $this->connection = Connection::GetInstance();

            $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
        }

        
}

?>