<?php 

    namespace DAO;

    use Models\Message as Message;
    use FFI\Exception;

    class MessageDAO {

        private $connection;
        private $tableName = "message";
        
        public function __construct (){

        }

        public function Add (Message $message){
            $query = "CALL Message_Add(?,?,?,?)";

            $parameters["idReservationS"] = $message->getIdReservation();
            $parameters["contentS"] = $message->getContent();
            $parameters["fechaS"] = $message->getFecha();
            $parameters["senderS"] = $message->getSender();
            
            try{
                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
            }catch(Exception $error){
                throw new Exception("No se pudo mandar el mensaje");
            }
        }

        public function GetById($idReservation){
            $query = "CALL Message_GetById(?)";
            $parameters['idReservationS'] = $idReservation;
            $chat = array();

            try{
                $this->connection = Connection::GetInstance();
                $results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
                foreach($results as $row){
                    $message = new Message();
                    $message->setIdMessage($row['idMessage']);
                    $message->setIdReservation($row['idReservation']);
                    $message->setContent($row['content']);
                    $message->setFecha($row['fecha']);
                    $message->setSender($row["sender"]);
                    array_push($chat,$message);
                }
                return $chat;
            }catch(Exception $e){
                throw new Exception("Error al cargar el chat");
            }
            
        }
    }
?>