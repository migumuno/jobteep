<?php
include_once 'Model/Exceptions/Collections/IncorrectKeyException.exception.php';
include_once 'Model/Exceptions/Collections/InvalidKeyException.exception.php';
include_once 'Model/Exceptions/Collections/NeedKeyException.exception.php';
include_once 'Model/Collection.class.php';

class MC {
	private $mc;
	public $enums;
	
	function MC() {
		$this->mc = new Collection();
		$this->enums = array(
			"activity", "article", "blog", "education", "experience", "forum", "info", "language", "settings", "proyect", "skill", "travel", "user", 
			"upgrade", "mtlculture", "mtlsport", "mtlart", "mtlgeek", "activitylanguage", "activityskill", "activitytravel", "educationlanguage", 
			"educationskill", "educationtravel", "experiencelanguage", "experienceskill", "experiencetravel", "proyectskill",
			"proyectlanguage", "proyecttravel", "proyectimg", "travellanguage", "origin"
		);
		
		for ($i = 0; $i < count($this->enums); $i++) {
			$this->store(new Collection(), $this->enums[$i]);
		}
	}
	
	public function store ($obj, $key) {
		try {
			$this->mc->addItem($obj, $key);
		} catch (NeedKeyException $e) {
			throw new NeedKeyException($e->getMessage());
		} catch (IncorrectKeyException $e) {
			throw new IncorrectKeyException($e->getMessage());
		}
	}
	
	public function load ($key) {
		try {
			return $this->mc->getItem($key);
		} catch (InvalidKeyException $e) {
			throw new InvalidKeyException($e->getMessage());
		}
	}
	
	public function erase ($key) {
		try {
			$this->mc->removeItem($key);
		} catch (InvalidKeyException $e) {
			throw new InvalidKeyException($e->getMessage());
		}
	}
}
?>