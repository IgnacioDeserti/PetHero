<?php
    namespace Models;

    class File{
        private $name;
        private $fullPath;
        private $type;
        private $tmp_name;
        private $error;
        private $size;

        public function __construct($name, $fullPath, $type, $tmp_name, $error, $size){
            $this->name = $name;
            $this->fullPath = $fullPath;
            $this->type = $type;
            $this->tmp_name = $tmp_name;
            $this->error = $error;
            $this->size = $size;
        }
    
    	/**
	 * @return mixed
	 */
	function getName() {
		return $this->name;
	}
	
	/**
	 * @param mixed $name 
	 * @return File
	 */
	function setName($name): self {
		$this->name = $name;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	function getFullPath() {
		return $this->fullPath;
	}
	
	/**
	 * @param mixed $fullPath 
	 * @return File
	 */
	function setFullPath($fullPath): self {
		$this->fullPath = $fullPath;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	function getType() {
		return $this->type;
	}
	
	/**
	 * @param mixed $type 
	 * @return File
	 */
	function setType($type): self {
		$this->type = $type;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	function getTmp_name() {
		return $this->tmp_name;
	}
	
	/**
	 * @param mixed $tmp_name 
	 * @return File
	 */
	function setTmp_name($tmp_name): self {
		$this->tmp_name = $tmp_name;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	function getError() {
		return $this->error;
	}
	
	/**
	 * @param mixed $error 
	 * @return File
	 */
	function setError($error): self {
		$this->error = $error;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	function getSize() {
		return $this->size;
	}
	
	/**
	 * @param mixed $size 
	 * @return File
	 */
	function setSize($size): self {
		$this->size = $size;
		return $this;
	}
}

?>