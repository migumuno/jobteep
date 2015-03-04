<?php
include_once 'Model/Elements/Content/Content.class.php';

abstract class Template extends Content {
	
	
	public function setElement($field, $value){
		return true;
	}
}
?>