<?php
include_once 'Model/Elements/Content/Relation/Relation.class.php';

class ActivitySkill extends Relation {
	
	
	function ActivitySkill() {
		$this->setBasic();
		$this->fields = array(
			"id_activity",
			"id_skill"
		);
		$this->checks = array(
			"int",
			"int"
		);
		$this->enum = "activityskill";
		$this->order = "id_activity ASC";
	}
}
?>