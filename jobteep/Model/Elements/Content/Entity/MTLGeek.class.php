<?php
include_once 'Model/Elements/Content/Entity/Entity.class.php';

class MTLGeek extends Entity {
	
	
	function MTLGeek() {
		$this->setBasic();
		$this->fields = array(
			"category",
			"title",
			"description",
			"version"
			
		);
		$this->checks = array(
			"notEmpty",
			"notEmpty",
			"none",
			"none"
		);
		$this->enum = "mtlgeek";
		$this->order = "date DESC";
	}
}
?>