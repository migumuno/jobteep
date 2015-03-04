<?php
include_once 'Model/Elements/Content/Relation/Relation.class.php';

class ActivityTravel extends Relation {
	
	
	function ActivityTravel() {
		$this->setBasic();
		$this->fields = array(
			"id_activity",
			"id_travel"
		);
		$this->checks = array(
			"int",
			"int"
		);
		$this->enum = "activitytravel";
		$this->order = "id_activity ASC";
	}
}
?>