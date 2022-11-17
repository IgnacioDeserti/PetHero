<?php

    namespace DAO;

    use Models\Reservation;
    use Exception;

    class ReservationDAO{
        private $connection;
        private $tableName = "reservation";

        public function __construct(){
        }


        
        public function Add(Reservation $reservation)
        {
            $query = "CALL Reservation_Add(?,?,?,?,?,?,?,?,?)";

            $parameters["idOwner"] = $reservation->getIdOwner();
            $parameters["idGuardian"] = $reservation->getIdGuardian();
            $parameters["idPet"] = $reservation->getIdPet();
            $parameters["breed"] = $reservation->getBreed();
            $parameters["animalType"] = $reservation->getAnimalType();
            $parameters["reservationDateStart"] = $reservation->getReservationDateStart();
            $parameters["reservationDateEnd"] = $reservation->getReservationDateEnd();
            $parameters["size"] = $reservation->getSize();
            $parameters["price"] = $reservation->getPrice();
            
            try{
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
            }catch(Exception $error){
                throw new Exception("No se pudo crear la reserva");
            }
        }

        public function GetReservationsByGuardian($idGuardian)
        {
            $reservationList = array();

            $query = "CALL Reservation_GetReservationsByIdGuardian(?)";

            $parameters["idGuardianS"] = $idGuardian;

            try{
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
            }catch(Exception $error){
                throw new Exception("El guardian con ese id no tiene reservas");
            }
        }

        public function GetReservationsById($idRes)
        {
            $query = "CALL Reservation_GetReservationById(?)";

            $parameters["idRes"] = $idRes;

            try{
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
                    $reservation->setPrice($row["price"]);
                    $reservation->setSize($row["size"]);
                }

                return $reservation;

            }catch(Exception $error){
                throw new Exception("No existe reserva con ese id");
            }
        }

        public function GetReservationsByOwner($idOwner)
        {
            $reviewList = array();

            $query = "CALL Reservation_GetReservationsByIdOwner(?)";

            $parameters["idOwnerS"] = $idOwner;

            try{
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
                        $reservation->setSize($row["size"]);
                        $reservation->setPrice($row["price"]);
                        array_push($reviewList, $reservation);
                }

                return $reviewList;
            }catch(Exception $error){
                throw new Exception("El dueño con ese id no tiene reservas");
            }
        }

        public function delete($id){
            $query = "CALL Reservation_Delete(?)";

            $parameters["id"] =  $id;

            try{
                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
            }catch(Exception $error){
                throw new Exception("No se pudo borrar la reserva");
            }
        }

        public function GetReservationDates($idGuardian)
        {
            $dates = array();

            $query = "CALL Reservation_GetReservationsByIdGuardian(?)";

            $parameters["idGuardianS"] = $idGuardian;

            try{
                $this->connection = Connection::GetInstance();

                $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

                foreach($result as $date){
                    array_push($dates, $date['reservationDateStart']);
                    array_push($dates, $date['reservationDateEnd']);
                    array_push($dates, $date['breed']);
                    array_push($dates, $date['animalType']);
                    array_push($dates, $date['size']);
                }

                return $dates;
            }catch(Exception $error){
                throw new Exception("No existe reserva con ese id");
            }
        }

        public function changeReservationStatus ($idReservation,$status){
            $query = "CALL Reservation_changeStatus(?,?)";

            $parameters["idReservationS"] = $idReservation;
            $parameters["statusS"] = $status;

            try{
                $this->connection = Connection::GetInstance();
                $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
            }catch(Exception $error){
                throw new Exception("No se pudo modificar la reserva");
            }
        }

        public function getReservationByStatusAndIdOwner($status, $idOwner)
        {
            $reservationList = array();

            $query = "CALL Reservation_getReservationByStatusAndIdOwner(?,?)";

            $parameters["stat"] = $status;
            $parameters["idOwnerR"] = $idOwner;

            try{
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
                    $reservation->setPrice($row["price"]);
                    $reservation->setSize($row["size"]);
                    array_push($reservationList, $reservation);
                }

                return $reservationList;
            }catch(Exception $error){
                return null;
            }

        }

        
        public function getReservationByStatusAndIdOwner2($status1, $status2, $idOwner)
        {
            $reservationList = array();

            $query = "CALL Reservation_getReservationByStatusAndIdOwner2(?,?,?)";

            $parameters["stat1"] = $status1;
            $parameters["stat2"] = $status2;
            $parameters["idOwnerR"] = $idOwner;

            try{
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
                    $reservation->setPrice($row["price"]);
                    $reservation->setSize($row["size"]);
                    array_push($reservationList, $reservation);
                }

                return $reservationList;
            }catch(Exception $error){
                return null;
            }

        }

        public function getReservationByStatusAndIdGuardian2($status1, $status2, $idGuardian)
        {
            $reservationList = array();

            $query = "CALL Reservation_getReservationByStatusAndIdOwner2(?,?,?)";
            $parameters["stat1"] = $status1;
            $parameters["stat2"] = $status2;
            $parameters["idGuardianR"] = $idGuardian;

            try{
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
                    $reservation->setPrice($row["price"]);
                    $reservation->setSize($row["size"]);
                    array_push($reservationList, $reservation);
                }

                return $reservationList;
            }catch(Exception $error){
                return null;
            }

        }

        public function getReservationByStatusAndIdGuardian($status, $idGuardian)
        {
            $reservationList = array();

            $query = "CALL Reservation_getReservationByStatusAndIdGuardian(?,?)";

            $parameters["stat"] = $status;
            $parameters["idGuardianR"] = $idGuardian;

            try{
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
                    $reservation->setPrice($row["price"]);
                    array_push($reservationList, $reservation);
                }

                return $reservationList;
            }catch(Exception $error){
                return null;
            }

        }
        
        public function updatePrice($idReservation){
            $reservationList = array();

            $query = "CALL reservation_changePrice(?)";

            $parameters["idReservationS"] = $idReservation;

            try{
                $this->connection = Connection::GetInstance();
                $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
            }catch(Exception $error){
                return null;
            }
        }
        
}

?>