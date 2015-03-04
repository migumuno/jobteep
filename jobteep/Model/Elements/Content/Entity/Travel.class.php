<?php
include_once 'Model/Elements/Content/Entity/Entity.class.php';

class Travel extends Entity {
	
	
	function Travel() {
		$this->setBasic();
		$this->fields = array(
			"type",
			"title",
			"story",
			"location",
			"start_date",
			"end_date",
			"version",
			"img"
		);
		$this->checks = array(
			"none",
			"notEmpty",
			"none",
			"notEmpty",
			"none",
			"none",
			"none",
			"none"
		);
		$this->enum = "travel";
		$this->order = "start_date DESC";
	}
}
?>