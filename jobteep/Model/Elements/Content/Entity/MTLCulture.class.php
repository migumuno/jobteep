<?php
include_once 'Model/Elements/Content/Entity/Entity.class.php';

class MTLCulture extends Entity {
	
	
	function MTLCulture() {
		$this->setBasic();
		$this->fields = array(
			"category",
			"title",
			"genre",
			"description",
			"version",
			"img"
			
		);
		$this->checks = array(
			"notEmpty",
			"notEmpty",
			"notEmpty",
			"none",
			"none",
			"none"
		);
		$this->enum = "mtlculture";
		$this->order = "date DESC";
	}
}
?>