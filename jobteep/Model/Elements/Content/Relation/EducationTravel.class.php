<?php
include_once 'Model/Elements/Content/Relation/Relation.class.php';

class EducationTravel extends Relation {
	
	
	function EducationTravel() {
		$this->setBasic();
		$this->fields = array(
			"id_education",
			"id_travel"
		);
		$this->checks = array(
			"int",
			"int"
		);
		$this->enum = "educationtravel";
		$this->order = "id_education ASC";
	}
}
?>