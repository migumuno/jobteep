<?php
include_once 'Model/Elements/Content/Entity/Entity.class.php';

class MTLArt extends Entity {
	
	
	function MTLArt() {
		$this->setBasic();
		$this->fields = array(
			"category",
			"title",
			"description",
			"img",
			"version"
			
		);
		$this->checks = array(
			"notEmpty",
			"notEmpty",
			"none",
			"none",
			"none"
		);
		$this->enum = "mtlart";
		$this->order = "date DESC";
	}
}
?>