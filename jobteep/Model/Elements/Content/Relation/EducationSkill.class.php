<?php
include_once 'Model/Elements/Content/Relation/Relation.class.php';

class EducationSkill extends Relation {
	
	
	function EducationSkill() {
		$this->setBasic();
		$this->fields = array(
			"id_education",
			"id_skill"
		);
		$this->checks = array(
			"int",
			"int"
		);
		$this->enum = "educationskill";
		$this->order = "id_education ASC";
	}
}
?>