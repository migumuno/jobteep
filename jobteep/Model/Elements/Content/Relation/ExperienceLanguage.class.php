<?php
include_once 'Model/Elements/Content/Relation/Relation.class.php';

class ExperienceLanguage extends Relation {
	
	
	function ExperienceLanguage() {
		$this->setBasic();
		$this->fields = array(
			"id_experience",
			"id_language"
		);
		$this->checks = array(
			"int",
			"int"
		);
		$this->enum = "experiencelanguage";
		$this->order = "id_experience ASC";
	}
}
?>