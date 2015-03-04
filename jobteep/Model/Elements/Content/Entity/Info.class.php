<?php
include_once 'Model/Elements/Content/Entity/Entity.class.php';

class Info extends Entity {
	
	
	function Info() {
		$this->setBasic();
		$this->fields = array(
			"name",
			"surname",
			"email",
			"native_language",
			"birthday",
			"telf1",
			"domain",
			"city",
			"country",
			"img",
			"id_fbk",
			"id_lnkdn",
			"sector1",
			"sector2",
			"sector3",
			"slogan",
			"profession",
			"description",
			"address",
			"lookingfor",
			"iam",
			"disponibility",
			"facebook",
			"linkedin",
			"twitter",
			"web",
			"version"
		);
		$this->checks = array(
			"notEmpty",
			"notEmpty",
			"none",
			"notEmpty",
			"notEmpty",
			"none",
			"notEmpty",
			"notEmpty",
			"notEmpty",
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
		$this->enum = "info";
		$this->order = "id_info DESC";
	}
}
?>