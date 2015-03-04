<?php
include_once 'Programs/Program.class.php';

class Profile extends Program {
	
	function Profile($template) {
		$this->info = array();
		$this->dir = 'Data/Templates/'.$template.'/';
		$this->name = 'PROFILE';
	}
}
?>