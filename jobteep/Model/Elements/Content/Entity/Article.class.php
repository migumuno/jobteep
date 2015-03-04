<?php
include_once 'Model/Elements/Content/Entity/Entity.class.php';

class Article extends Entity {
	
	
	function Article() {
		$this->setBasic();
		$this->fields = array(
			"title",
			"url",
			"sector",
			"description",
			"date",
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
			"none"
		);
		$this->enum = "article";
		$this->order = "date DESC";
	}
}
?>