<?php
include_once 'Model/Elements/Content/Relation/Relation.class.php';

class ProyectSkill extends Relation {
	
	
	function ProyectSkill() {
		$this->setBasic();
		$this->fields = array(
			"id_proyect",
			"id_skill"
		);
		$this->checks = array(
			"int",
			"int"
		);
		$this->enum = "proyectskill";
		$this->order = "id_skill ASC";
	}
}
?>