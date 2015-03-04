<?php
include_once 'Model/Elements/Content/Relation/Relation.class.php';

class ActivityHobby extends Relation {
	
	
	function ActivityHobby() {
		$this->setBasic();
		$this->fields = array(
			"id_activity",
			"id_hobby"
		);
		$this->checks = array(
			"int",
			"int"
		);
		$this->enum = "activityhobby";
		$this->order = "id_activity ASC";
	}
}
?>