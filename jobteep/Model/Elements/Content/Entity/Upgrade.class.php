<?php
include_once 'Model/Elements/Content/Entity/Entity.class.php';

class Upgrade extends Entity {
	
	
	function Upgrade() {
		$this->setBasic();
		$this->fields = array(
			"company1",
			"company2",
			"company3",
			"company4",
			"company5",
			"obj1",
			"obj2",
			"obj3",
			"focus",
			"end",
			"future",
			"badnew",
			"overloaded",
			"version"
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
			"none",
			"none",
			"none",
			"none",
			"none"
		);
		$this->enum = "upgrade";
		$this->order = "id_upgrade ASC";
	}
}
?>