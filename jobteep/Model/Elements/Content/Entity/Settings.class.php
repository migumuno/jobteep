<?php
include_once 'Model/Elements/Content/Entity/Entity.class.php';

class Settings extends Entity {
	
	function Settings() {
		$this->setBasic();
		$this->fields = array(
			"template",
			"public",
			"v1",
			"work",
			"education",
			"language",
			"skill",
			"proyect",
			"activity",
			"interests",
			"travel",
			"publication",
			"mtlart",
			"mtlculture",
			"mtlsport",
			"objetives",
			"background",
			"analytics",
			"teepcardTxtColor",
			"teepcardImg",
			"teepcardFont",
			"teepcardFontSize"
		);
		$this->checks = array(
			"none",
			"int",
			"none",
			"none",
			"none",
			"none",
			"none",
			"none",
			"none",
			"none",
			"none",
			"none",
			"none",
			"none",
			"none",
			"none",
			"none",
			"none",
			"none",
			"none",
			"none",
			"none"
		);
		$this->enum = "settings";
		$this->order = "id_settings DESC";
	}
}
?>