<?php
include_once 'Model/Elements/Content/Entity/Entity.class.php';

class Forum extends Entity {
	
	
	function Forum() {
		$this->setBasic();
		$this->fields = array(
			"name",
			"url",
			"user",
			"sector1",
			"sector2",
			"description",
			"themes",
			"version"
		);
		$this->checks = array(
			"notEmpty",
			"notEmpty",
			"notEmpty",
			"none",
			"none",
			"none",
			"none",
			"none"
		);
		$this->enum = "forum";
		$this->order = "name ASC";
	}
}
?>