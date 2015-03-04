<?php
include_once 'Model/Elements/Content/Entity/Entity.class.php';

class User extends Entity {
	
	
	function User() {
		$this->setBasic();
		$this->fields = array(
			"user",
			"pass",
			"keyword",
			"state",
			"dir"
		);
		$this->checks = array(
			"notEmpty",
			"notEmpty",
			"none",
			"intN",
			"none"
		);
		$this->enum = "user";
		$this->order = "id_user DESC";
	}
}
?>