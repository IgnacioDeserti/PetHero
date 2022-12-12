<?php 

    namespace DAO;

    use Models\Message as Message;
    use FFI\Exception;

    class MessageDAO {
        
        public function __construct (){

        }

        public function Add (Message $message){
            $query = "CALL Message_Add(?,?,?,?,?)";

            $parameters["idOwnerS"] = $message->getIdOwner();
            $parameters["idGuardianS"] = $message->getidGuardian();
            $parameters["contentS"] = $message->getContent();
            $parameters["fechaS"] = $message->getFecha();
            $parameters["senderS"] = $message->getSender();
            
            try{
                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
            }catch(Exception $error){
                throw new Exception("No se pudo agregar la reseña");
            }
        }

        public function GetById($idOwner,$idGuardian){
            $query = "CALL Message_GetById(?,?)";
            $parameters['idOwnerS'] = $idOwner;
            $parameters['idGuardianS'] = $idGuardian;
            $chat = array();

            try{
                $this->connection = Connection::GetInstance();
                $results = $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
                foreach($results as $row){
                    $message = new Message();
                    $message->setIdMessage($row['idMessage']);
                    $message->setIdOwner($row['idOwner']);
                    $message->setIdGuardian($row['idGuardian']);
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