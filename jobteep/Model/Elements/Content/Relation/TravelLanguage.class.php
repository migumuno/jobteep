<?php
include_once 'Model/Elements/Content/Relation/Relation.class.php';

class TravelLanguage extends Relation {
	
	
	function TravelLanguage() {
		$this->setBasic();
		$this->fields = array(
			"id_travel",
			"id_language"
		);
		$this->checks = array(
			"int",
			"int"
		);
		$this->enum = "travellanguage";
		$this->order = "id_travel ASC";
	}
}
?>