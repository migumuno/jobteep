<?php
include_once 'Model/Exceptions/Collections/IncorrectKeyException.exception.php';
include_once 'Model/Exceptions/Collections/InvalidKeyException.exception.php';
include_once 'Model/Exceptions/Collections/NeedKeyException.exception.php';

class Collection {
	private $members;
	
	function Collection() {
		$this->members = array();
	}
	
	public function getArray () {
		return $this->members;
	}
	
	public function addItem ($obj, $key = null) {
		if (!is_null($key)) {
			if ($this->exists($key))
				throw new IncorrectKeyException("La clave ". $key ." asignada al Item ya está en uso.");
			else {
				$this->members[$key] = $obj;
			}
		} else 
			throw new NeedKeyException("Es necesario asignar una clave al Item.");
	}
	
	public function removeItem ($key) {
		if ($this->exists($key))
			unset($this->members[$key]);
		else
			throw new InvalidKeyException("La clave ". $key ." no se identifica con ningún Item.");
	}
	
	public function getItem ($key) {
		if ($this->exists($key))
			return $this->members[$key];
		else
			throw new InvalidKeyException("La clave ". $key ." no se identifica con ningún Item.");
	}
	
	public function emptyCollection () {
		foreach ($this->members as $key => $v) {
			unset($this->members[$key]);
		}
	}
	
	public function length () {
		return count($this->members);
	}
	
	public function exists ($key) {
		return (isset($this->members[$key]));
	}
}
?>