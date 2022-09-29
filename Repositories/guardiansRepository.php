<?php

    namespace Repositories;

    use Models\Guardian as Guardian;
    use Repositories\IGuardians;
    use Models\Review as Review;

    class guardiansRepository implements IGuardians{

        private $guardianList;
        private $fileName;

        public function __construct(){
            $this->fileName = dirname(__DIR__)."/Data/guardians.json";
        }


        public function add(guardian $newGuardian){
            $this->retrieveData();
            array_push($this->guardianList, $newGuardian);
            $this->saveData();
        }
        
        public function delete($id){

        }

        public function getAll(){
            $this->retrieveData();
            return $this->guardianList;
        }

        private function saveData(){
            $arrayToEncode = array();

            foreach($this->guardianList as $guardian){
                    $guardian = new guardian();
                    $valuesArray["name"] = $guardian->getName();
                    $valuesArray["adress"] = $guardian->getAddress();
                    $valuesArray["email"] = $guardian->getEmail();
                    $valuesArray["number"] = $guardian->getNumber();
                    $valuesArray["availability"] = $guardian->getAvailability();
                    $valuesArray["size"] = $guardian->getSize();
                    $aux = $guardian->getReviews();
                    $arrayReviews = array();
                    foreach($aux as $review){
                        $value["rating"] = $review->getRating();
                        $value["observations"] = $review->getObservations();
                        $value["userName"] = $review->getUserName();
                        array_push($arrayReviews, $value);
                    }
                    $valuesArray["reviews"] = $arrayReviews;
                    array_push($arrayToEncode, $valuesArray);
                }

            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

            file_put_contents($this->GetJsonFilePath(), $jsonContent);
        } 

        private function retrieveData(){
            $this->guardianList = array();

            if(file_exists($this->fileName)){
                $jsonContent = file_get_contents($this->GetJsonFilePath());

                $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach($arrayToDecode as $valuesArray){
                    $guardian = new guardian();
                    $guardian->setName($valuesArray["name"]);
                    $guardian->setAddress($valuesArray["adress"]);
                    $guardian->setEmail($valuesArray["email"]);
                    $guardian->setNumber($valuesArray["number"]);
                    $guardian->setAvailability($valuesArray["availability"]);
                    $guardian->setSize($valuesArray["size"]);
                    $aux = $valuesArray["reviews"];
                    $arrayReviews = array();
                    foreach($aux as $value){
                        $review = new Review();
                        $review->setRating($value["rating"]);
                        $review->setObservations($value["observations"]);
                        $review->setUserName($value["userName"]);
                        array_push($arrayReviews, $review);
                    }
                    $guardian->setReviews($arrayReviews);
                    array_push($this->guardianList, $guardian);
                }
            }
        }

        private function GetJsonFilePath(){

            $initialPath = "Data/owners.json";
            if(file_exists($initialPath)){
                $jsonFilePath = $initialPath;
            }else{
                $jsonFilePath = "../".$initialPath;
            }

            return $jsonFilePath;
        }
}

?>