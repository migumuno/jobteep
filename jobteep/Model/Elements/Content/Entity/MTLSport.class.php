<?php
include_once 'Model/Elements/Content/Entity/Entity.class.php';

class MTLSport extends Entity {
	
	
	function MTLSport() {
		$this->setBasic();
		$this->fields = array(
			"category",
			"frequency",
			"level",
			"description",
			"version"
			
		);
		$this->checks = array(
			"notEmpty",
			"int",
			"none",
			"none",
			"none"
		);
		$this->enum = "mtlsport";
		$this->order = "date DESC";
	}
}
?>