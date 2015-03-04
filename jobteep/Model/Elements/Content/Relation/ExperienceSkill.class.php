<?php
include_once 'Model/Elements/Content/Relation/Relation.class.php';

class ExperienceSkill extends Relation {
	
	
	function ExperienceSkill() {
		$this->setBasic();
		$this->fields = array(
			"id_experience",
			"id_skill"
		);
		$this->checks = array(
			"int",
			"int"
		);
		$this->enum = "experienceskill";
		$this->order = "id_experience ASC";
	}
}
?>