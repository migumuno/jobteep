<?php
include_once 'Model/Elements/Content/Entity/Entity.class.php';

class Blog extends Entity {
	
	
	function Blog() {
		$this->setBasic();
		$this->fields = array(
			"name",
			"url",
			"month_views",
			"sector1",
			"sector2",
			"sector3",
			"description",
			"start_date",
			"end_date",
			"img",
			"version"
		);
		$this->checks = array(
			"notEmpty",
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
		$this->enum = "blog";
		$this->order = "start_date DESC";
	}
}
?>