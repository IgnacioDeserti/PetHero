<?php
    namespace Controllers;

    use DAO\petDAO;
    use DAO\guardiansDAO as guardiansDAO;
    use DAO\ownersDAO as ownersDAO;
    use DAO\sizeDAO;
    use Models\Owner as Owner;
    use DAO\Guardian_x_SizeDAO;
    use Models\Guardian as Guardian;
    use DAO\ReservationDAO;
    use Models\Message as Message;
    use DAO\MessageDAO as MessageDAO;
    use Exception;

class HomeController
{

    private $guardianDAO;
    private $ownerDAO;
    private $PetDAO;
    private $sizeDAO;
    private $gxsDAO;
    private $reservationDAO;
    private $messageDAO;

    public function __construct()
    {
        $this->guardianDAO = new guardiansDAO();
        $this->ownerDAO = new ownersDAO();
        $this->PetDAO = new petDAO();
        $this->sizeDAO = new sizeDAO();
        $this->gxsDAO = new Guardian_x_SizeDAO();
        $this->reservationDAO = new ReservationDAO();
        $this->messageDAO = new MessageDAO();
    }

    public function Index()
    {
        require_once(VIEWS_PATH . "inicio.php");
    }

    public function logOut()
    {
        session_destroy();
        $alert = [
            "type" => "success",
            "text" => "Sesion cerrada con exito!"
        ];
        require_once(VIEWS_PATH . "inicio.php");
    }

    public function inicioSesion($email, $password, $typeUser)
    {   
        $this->reservationDAO->updateEndedReservations();
        try {
            $this->checkTypeUser($typeUser);
            if ($typeUser == 'G') {
                try {
                    $aux = $this->searchGuardian($email, $password);
                    $_SESSION["idUser"] = $aux->getIdGuardian();
                    $_SESSION["typeUser"] = $aux->getTypeUser();
                    $alert = [
                        "type" => "success",
                        "text" => "Sesion iniciada con exito!"
                    ];
                    $this->selectViewGuardian($aux, $alert);
                } catch (Exception $e) {
                    $alert = [
                        "type" => "alert",
                        "text" => $e->getMessage()
                    ];
                    require_once(VIEWS_PATH . "inicio.php");
                }
            } else {
                try {
                    $aux = $this->searchOwner($email, $password);
                    $_SESSION["idUser"] = $aux->getIdOwner();
                    $_SESSION["typeUser"] = $aux->getTypeUser();
                    $alert = [
                        "type" => "success",
                        "text" => "Sesion iniciada con exito!"
                    ];
                    $this->selectView($aux->getIdOwner(), $alert);
                } catch (Exception $e) {
                    $alert = [
                        "type" => "alert",
                        "text" => $e->getMessage()
                    ];
                    require_once(VIEWS_PATH . "inicio.php");
                }
            }
        } catch (Exception $e) {
            $alert = [
                "type" => "alert",
                "text" => $e->getMessage()
            ];
            require_once(VIEWS_PATH . "inicio.php");
        }

    }

    public function checkTypeUser($typeUser)
    {
        if ($typeUser != 'G' && $typeUser != 'O') {
            throw new Exception('Elija un tipo de usuario');
        }
    }

    public function searchOwner($email, $password)
    {
        $aux = $this->ownerDAO->getOwner($email);

        if ($aux->getEmail() != null) {
            if (strcmp($aux->getPassword(), $password) == 0) {
                return $aux;
            } else {
                throw new Exception("Password invalida");
            }
        } else {
            throw new Exception("Email invalido");
        }
    }

    public function searchGuardian($email, $password)
    {
        $aux = $this->guardianDAO->getGuardian($email);

        if ($aux->getEmail() != null) {
            if (strcmp($aux->getPassword(), $password) == 0) {
                return $aux;
            } else {
                throw new Exception("Password invalida");
            }
        } else {
            throw new Exception("Email invalido");
        }
    }

    public function selectView($id, $alert = null)
    {

        try {
            $arrayListPet = $this->PetDAO->GetPetByIdOwner($id);
            $size = $this->sizeDAO;
            if (count($arrayListPet) > 0) {
                require_once(VIEWS_PATH . "validate-session.php");
                require_once(VIEWS_PATH . "listPet.php");
            } else {
                require_once(VIEWS_PATH . "validate-session.php");
                require_once(VIEWS_PATH . "addPet.php");
            }
        } catch (Exception $e) {
            $alert = [
                "type" => "alert",
                "text" => $e->getMessage()
            ];
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "addPet.php");
        }
    }

    public function selectViewGuardian($aux, $alert = null)
    {

        try {
            $this->guardianDAO->getReservationStart($aux->getIdGuardian());
            $wcReservationList = $this->reservationDAO->getReservationByStatusAndIdGuardian("Esperando confirmacion", $aux->getIdGuardian());
            $fReservationList = $this->reservationDAO->getReservationByStatusAndIdGuardian2("Finalizado", "Finalizado Revisado", $aux->getIdGuardian());
            $cReservationList = $this->reservationDAO->getReservationByStatusAndIdGuardian2("Aceptada", "Esperando pago", $aux->getIdGuardian());
            $allpets = $this->PetDAO;
            $guardian = $this->guardianDAO;
            $owner = $this->ownerDAO;
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "listReservationGuardian.php");
        } catch (Exception $e) {
            require_once(VIEWS_PATH . "modifyAvailability.php");
        }
    }

    public function createProfile()
    {   
        $this->reservationDAO->updateEndedReservations();
        require_once(VIEWS_PATH . "createProfile.php");
    }

    public function profileType($do)
    {
        if ($_POST) {
            if ($do == "guardian") {
                require_once(VIEWS_PATH . "createGuardianProfile.php");
            } else if ($do == "owner") {
                require_once(VIEWS_PATH . "createOwnerProfile.php");
            } else if ($do == "goBack") {
                require_once(VIEWS_PATH . "inicio.php");
            }
        }
    }

    public function createOwnerProfile($name, $address, $email, $number, $userName, $password, $typeUser)
    {
        if ($_POST) {
            $this->ownerDAO->getAll();
            $newOwner = new Owner();
            $newOwner->setName($name);
            $newOwner->setAddress($address);
            $newOwner->setEmail($email);
            $newOwner->setNumber($number);
            $newOwner->setUserName($userName);
            $newOwner->setPassword($password);
            $newOwner->setTypeUser($typeUser);

            try {
                $this->verifyEmailUser($email, $userName);
                $this->ownerDAO->Add($newOwner);
                $aux = $this->ownerDAO->getOwner($email);
                $_SESSION["idUser"] = $aux->getIdOwner();
                $_SESSION["typeUser"] = $aux->getTypeUser();
                $alert = [
                    "type" => "success",
                    "text" => "Pefil creado con exito!"
                ];
                require_once(VIEWS_PATH . 'addPet.php');
            } catch (Exception $e) {
                $alert = [
                    "type" => "alert",
                    "text" => $e->getMessage()
                ];
                require_once(VIEWS_PATH . "createOwnerProfile.php");
            }

        }
    }

    private function verifyEmailUser($email, $userName)
    {
        $searched = $this->ownerDAO->getOwner($email);
        if ($searched->getEmail() != null) {
            throw new Exception("Email ya registrado");
        } else {
            $searched = $this->guardianDAO->getGuardian($email);
            if ($searched->getEmail() != null) {
                throw new Exception("Email ya registrado");
            }
        }

        $searched = $this->ownerDAO->getOwnerByUserName($userName);
        if ($searched->getUserName() != null) {
            throw new Exception("Nombre de usuario ya registrado");
        } else {
            $searched = $this->guardianDAO->getGuardianByUserName($userName);
            if ($searched->getUserName() != null) {
                throw new Exception("Nombre de usuario ya registrado");
            }
        }

    }

    public function createGuardianProfile($name, $address, $email, $number, $userName, $password, $size, $price, $typeUser)
    {
        if ($_POST) {
            $newGuardian = new Guardian();
            $newGuardian->setName($name);
            $newGuardian->setAddress($address);
            $newGuardian->setEmail($email);
            $newGuardian->setNumber($number);
            $newGuardian->setUserName($userName);
            $newGuardian->setPassword($password);
            $newGuardian->setPrice($price);
            $newGuardian->setTypeUser($typeUser);

            try {
                $this->verifyEmailUser($email, $userName);
                $this->guardianDAO->Add($newGuardian);
                $aux = $this->guardianDAO->getGuardian($email);
                $_SESSION["idUser"] = $aux->getIdGuardian();
                $_SESSION["typeUser"] = $aux->getTypeUser();
                foreach ($size as $aux) {
                    $this->gxsDAO->Add($_SESSION["idUser"], $aux);
                }
                $alert = [
                    "type" => "success",
                    "text" => "Perfil creado con exito!"
                ];
                require_once(VIEWS_PATH . 'modifyAvailability.php');
            } catch (Exception $e) {
                $alert = [
                    "type" => "alert",
                    "text" => $e->getMessage()
                ];
                require_once(VIEWS_PATH . "createGuardianProfile.php");
            }
        }
    }

    public function LoadChat($content = '', $idReservation = null)
    {
        if ($idReservation == null) {
            $alert = [
                "type" => "error",
                "text" => "Error al entrar al chat"
            ];
            require_once(VIEWS_PATH . 'validate-session.php');
            require_once(VIEWS_PATH . "inicio.php");
        }
        $reservation = $this->reservationDAO->GetReservationsById($idReservation);
        $owners = $this->ownerDAO;
        $guardians = $this->guardianDAO;
        if ($content != '') {
            date_default_timezone_set("America/Buenos_Aires");
            $date = date("Y-m-d h:i:sa");
            $message = new Message();
            $message->setIdReservation($idReservation);
            $message->setFecha($date);
            $message->setSender($_SESSION['typeUser']);
            $message->setContent($content);
            $this->messageDAO->Add($message);
        }
        $chat = array();
        $chat = $this->messageDAO->GetById($idReservation);
        $name = $this->getNameChat($idReservation);

        require_once(VIEWS_PATH . 'validate-session.php');
        require_once(VIEWS_PATH . 'chat.php');
    }

    public function getNameChat($idReservation)
    {
        $res = $this->reservationDAO->GetReservationsById($idReservation);
        if ($_SESSION["typeUser"] == "O") {
            return $this->guardianDAO->getNameById($res->getIdGuardian());
        } else {
            return $this->ownerDAO->getNameById($res->getIdOwner());
        }
    }

}
    

?>