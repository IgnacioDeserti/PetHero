<?php

    namespace DAO;

use Countable;
use Models\PaymentCoupon;
    use Exception;

    class PaymentCouponDAO {
        private $connection;

        public function __construct(){
        }
        
        public function Add(PaymentCoupon $payment)
        {
            $query = "CALL PaymentCoupon_Add(?, ?, ?, ?, ?, ?, ?,?)";

            $parameters["idPaymentS"] = $payment->getIdPayment();
            $parameters["ownerNameS"] = $payment->getOwnerName();
            $parameters["guardianNameS"] = $payment->getGuardianName();
            $parameters["petNameS"] = $payment->getPetName();
            $parameters["priceS"] = $payment->getPrice();
            $parameters["dateS"] = $payment->getDate();
            $parameters["titularS"] = $payment->getTitular();
            $parameters["reservationNumberS"] = $payment->getReservationNumber();

            try{
                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
            }catch(Exception $error){
                throw new Exception("No se pudo realizar el pago");
            }

        }

        public function getPaymentByIdReservation ($idRes)
        {
            $arrayPayment = array();

            $query = "CALL paymentCoupon_getPaymentById(?)";

            $parameters["idRes"] = $idRes;

            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
            foreach($result as $row){
                $payment = new PaymentCoupon();
                $payment->setIdPayment($row['idPayment']);
                $payment->setOwnerName($row['ownerName']);
                $payment->setGuardianName($row['guardianName']);
                $payment->setPetName($row['petName']);
                $payment->setPrice($row['price']);
                $payment->setDate($row['dateP']);
                $payment->setTitular($row['titular']);
                $payment->setReservationNumber($row['reservationNumber']);
                array_push($arrayPayment, $payment);
            }

            return $arrayPayment;
            
        }
    }



?>