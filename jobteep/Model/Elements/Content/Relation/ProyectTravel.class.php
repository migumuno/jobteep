<?php
include_once 'Model/Elements/Content/Relation/Relation.class.php';

class ProyectTravel extends Relation {
	
	
	function ProyectTravel() {
		$this->setBasic();
		$this->fields = array(
			"id_proyect",
			"id_travel"
		);
		$this->checks = array(
			"int",
			"int"
		);
		$this->enum = "proyecttravel";
		$this->order = "id_travel ASC";
	}
}
?>