<?php
include_once 'Model/Elements/Content/Relation/Relation.class.php';

class EducationLanguage extends Relation {
	
	
	function EducationLanguage() {
		$this->setBasic();
		$this->fields = array(
			"id_education",
			"id_language"
		);
		$this->checks = array(
			"int",
			"int"
		);
		$this->enum = "educationlanguage";
		$this->order = "id_education ASC";
	}
}
?>