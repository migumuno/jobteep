<?php
include_once 'Programs/Program.class.php';

class Company extends Program {
	
	function Company() {
		$this->info = array();
		$this->dir = 'Programs/Company/';
		$this->name = 'COMPANY';
	}
}
?>