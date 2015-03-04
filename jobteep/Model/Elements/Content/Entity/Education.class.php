<?php
include_once 'Model/Elements/Content/Entity/Entity.class.php';

class Education extends Entity {
	
	
	function Education() {
		$this->setBasic();
		$this->fields = array(
			"branch",
			"specialty",
			"sector",
			"subsector",
			"qualification",
			"typeCenter",
			"nameCenter",
			"titulation",
			"description",
			"start_date",
			"end_date",
			"certificate",
			"version",
			"end"
		);
		$this->checks = array(
			"none",
			"none",
			"none",
			"none",
			"none",
			"none",
			"notEmpty",
			"notEmpty",
			"none",
			"none",
			"none",
			"none",
			"none",
			"none"
		);
		$this->enum = "education";
		$this->order = "start_date DESC";
	}
}
?>