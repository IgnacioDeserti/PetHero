<?php namespace controllers;

use Models\File;

class FileController
{
     private $uploadFilePath;
     private $allowedExtensions;
     private $maxSize;

     function __construct() {
          $this->allowedExtensions = array('png', 'jpg', 'gif', 'mp4');
          $this->maxSize = 5000000000000000000;
          $this->uploadFilePath = IMG_ROOT;
     }

     public function getAllowedExtensions() {
          return $this->allowedExtensions;
     }

     public function getMaxSize() {
          return $this->maxSize;
     }

     public function upload($file, $tipo = null) {

          $fileAvatar = new File($file['name'], $file['full_path'], $file['type'], $file['tmp_name'], $file['error'], $file['size']);

          $filePath = $this->uploadFilePath . "/".$tipo."/";

          if(!file_exists($filePath))
               mkdir($filePath);

          $fileName = $fileAvatar->getName();

          $fileLocation = $filePath . $fileName;
          $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

          if(in_array($fileExtension, $this->allowedExtensions) ) {

               if(!file_exists($fileLocation)) {

                    if($fileAvatar->getSize() < $this->maxSize) {

                         if (move_uploaded_file( $fileAvatar->getTmp_name(), $fileLocation)){

                              return IMG_PATH . "/" . $tipo . "/" . $fileName;
                         }
                    }
               }
          }
          return false;
     }
}