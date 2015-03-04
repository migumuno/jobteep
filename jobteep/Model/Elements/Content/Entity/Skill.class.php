<?php
include_once 'Model/Elements/Content/Entity/Entity.class.php';

class Skill extends Entity {
	
	
	function Skill() {
		$this->setBasic();
		$this->fields = array(
			"sector",
			"name",
			"self",
			"level",
			"story",
			"certificate",
			"version"
		);
		$this->checks = array(
			"none",
			"notEmpty",
			"none",
			"none",
			"none",
			"none",
			"none"
		);
		$this->enum = "skill";
		$this->order = "name ASC";
	}
}
?>