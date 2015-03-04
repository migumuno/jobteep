<?php
include_once 'Model/Elements/Content/Entity/Entity.class.php';

class Activity extends Entity {
	
	
	function Activity() {
		$this->setBasic();
		$this->fields = array(
			"category",
			"title",
			"description",
			"start_date",
			"end_date",
			"sector",
			"responsability",
			"responsabilities",
			"knowledge",
			"version"
		);
		$this->checks = array(
			"notEmpty",
			"notEmpty",
			"none",
			"none",
			"none",
			"none",
			"int",
			"none",
			"none",
			"none"
		);
		$this->enum = "activity";
		$this->order = "start_date DESC";
	}
}
?>