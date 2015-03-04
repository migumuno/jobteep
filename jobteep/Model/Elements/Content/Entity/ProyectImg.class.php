<?php
include_once 'Model/Elements/Content/Entity/Entity.class.php';

class ProyectImg extends Entity {
	
	
	function ProyectImg() {
		$this->setBasic();
		$this->fields = array(
			"id_proyect",
			"file",
			"name",
			"description"
			
		);
		$this->checks = array(
			"none",
			"none",
			"notEmpty",
			"none"
		);
		$this->enum = "proyectimg";
		$this->order = "id_proyectimg ASC";
	}
}
?>