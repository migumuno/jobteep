<?php
include_once 'Model/Elements/Content/Entity/Entity.class.php';

class Language extends Entity {
	
	
	function Language() {
		$this->setBasic();
		$this->fields = array(
			"name",
			"level",
			"story",
			"certificate",
			"version"
		);
		$this->checks = array(
			"notEmpty",
			"none",
			"none",
			"none",
			"none"
		);
		$this->enum = "language";
		$this->order = "name ASC";
	}
}
?>