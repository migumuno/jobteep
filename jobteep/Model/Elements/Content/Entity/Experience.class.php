<?php
include_once 'Model/Elements/Content/Entity/Entity.class.php';

class Experience extends Entity {
	
	
	function Experience() {
		$this->setBasic();
		$this->fields = array(
			"sector",
			"subsector",
			"company",
			"position",
			"description",
			"start_date",
			"end_date",
			"type",
			"version"
		);
		$this->checks = array(
			"none",
			"none",
			"notEmpty",
			"notEmpty",
			"none",
			"none",
			"none",
			"none",
			"none"
		);
		$this->enum = "experience";
		$this->order = "start_date DESC";
	}
}
?>