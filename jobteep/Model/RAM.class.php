<?php
include_once 'Model/Exceptions/Collections/IncorrectKeyException.exception.php';
include_once 'Model/Exceptions/Collections/InvalidKeyException.exception.php';
include_once 'Model/Exceptions/Collections/NeedKeyException.exception.php';
include_once 'Model/Collection.class.php';

class RAM {
	private $RAM;
	
	function RAM() {
		$this->RAM = new Collection();
	}
	
	public function store ($obj, $key) {
		try {
			$this->RAM->addItem($obj, $key);
		} catch (NeedKeyException $e) {
			throw new NeedKeyException($e->getMessage());
		} catch (IncorrectKeyException $e) {
			throw new IncorrectKeyException($e->getMessage());
		}
	}
	
	public function load ($key) {
		try {
			return $this->RAM->getItem($key);
		} catch (InvalidKeyException $e) {
			throw new InvalidKeyException($e->getMessage());
		}
	}
	
	public function erase ($key) {
		try {
			$this->RAM->removeItem($key);
		} catch (InvalidKeyException $e) {
			throw new InvalidKeyException($e->getMessage());
		}
	}
}
?>