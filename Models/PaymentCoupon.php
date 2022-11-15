<?php 

namespace Models;

class PaymentCoupon {

    private $idPayment;
    private $ownerName;
    private $guardianName;
    private $petName;
    private $price;
    private $date;
    private $titular;
    private $reservationNumber;
    
    public function __construct(){
    }
 
    public function getOwnerName()
    {
        return $this->ownerName;
    }

    public function setOwnerName($ownerName)
    {
        $this->ownerName = $ownerName;
    }

    public function getGuardianName()
    {
        return $this->guardianName;
    }

    public function setGuardianName($guardianName)
    {
        $this->guardianName = $guardianName;
    }

    public function getPetName()
    {
        return $this->petName;
    }

    public function setPetName($petName)
    {
        $this->petName = $petName;

    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;

    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getTitular()
    {
        return $this->titular;
    }

    public function setTitular($titular)
    {
        $this->titular = $titular;
    }

    public function getReservationNumber()
    {
        return $this->reservationNumber;
    }
 
    public function setReservationNumber($reservationNumber)
    {
        $this->reservationNumber = $reservationNumber;

    }

    public function getIdPayment()
    {
        return $this->idPayment;
    }

    public function setIdPayment($idPayment)
    {
        $this->idPayment = $idPayment;

        return $this;
    }
}

?>