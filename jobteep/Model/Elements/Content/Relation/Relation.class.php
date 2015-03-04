<?php
include_once 'Model/Elements/Content/Content.class.php';

abstract class Relation extends Content {
	
	
	public function setElement($field, $value){
		return true;
	}
}
?>