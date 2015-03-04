<?php
include_once 'Model/Elements/Content/Relation/Relation.class.php';

class ProyectLanguage extends Relation {
	
	
	function ProyectLanguage() {
		$this->setBasic();
		$this->fields = array(
			"id_proyect",
			"id_language"
		);
		$this->checks = array(
			"int",
			"int"
		);
		$this->enum = "proyectlanguage";
		$this->order = "id_language ASC";
	}
}
?>