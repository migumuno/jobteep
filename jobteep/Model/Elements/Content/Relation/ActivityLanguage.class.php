<?php
include_once 'Model/Elements/Content/Relation/Relation.class.php';

class ActivityLanguage extends Relation {
	
	
	function ActivityLanguage() {
		$this->setBasic();
		$this->fields = array(
			"id_activity",
			"id_language"
		);
		$this->checks = array(
			"int",
			"int"
		);
		$this->enum = "activitylanguage";
		$this->order = "id_activity ASC";
	}
}
?>