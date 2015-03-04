<?php
include_once 'Model/Elements/Content/Relation/Relation.class.php';

class ExperienceTravel extends Relation {
	
	
	function ExperienceTravel() {
		$this->setBasic();
		$this->fields = array(
			"id_experience",
			"id_travel"
		);
		$this->checks = array(
			"int",
			"int"
		);
		$this->enum = "experiencetravel";
		$this->order = "id_experience ASC";
	}
}
?>