<?php
include_once 'Model/Elements/Content/Entity/Entity.class.php';

class Proyect extends Entity {
	
	
	function Proyect() {
		$this->setBasic();
		$this->fields = array(
			"experience",
			"education",
			"title",
			"description",
			"start_date",
			"end_date",
			"self",
			"file",
			"sector",
			"subsector",
			"reason",
			"responsability",
			"responsabilities",
			"knowledge",
			"version"
		);
		$this->checks = array(
			"none",
			"none",
			"notEmpty",
			"none",
			"none",
			"none",
			"none",
			"none",
			"none",
			"none",
			"none",
			"int",
			"none",
			"none",
			"none"
		);
		$this->enum = "proyect";
		$this->order = "start_date DESC";
	}
}
?>