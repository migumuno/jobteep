<?php
include_once 'Programs/Program.class.php';

class Admin extends Program {
	
	function Admin() {
		$this->info = array();
		$this->dir = 'Programs/Admin/';
		$this->name = 'ADMIN';
	}
}
?>