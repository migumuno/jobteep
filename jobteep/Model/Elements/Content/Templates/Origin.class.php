<?php
include_once 'Model/Elements/Content/Templates/Template.class.php';

class Origin extends Template {
	
	
	function Origin() {
		$this->setBasic();
		$this->fields = array(
			"header_img",
			"gama",
			"txtD1",
			"imgD1",
			"txtD2",
			"imgD2",
			"typeD3",
			"imgD3",
			"txtD3",
			"videoD3"
		);
		$this->checks = array(
			"none",
			"none",
			"none",
			"none",
			"none",
			"none",
			"none",
			"none",
			"none",
			"none"
		);
		$this->enum = "origin";
		$this->order = "id_origin DESC";
	}
}
?>