<?php
include_once 'Programs/Program.class.php';

class Web extends Program {
	
	function Web() {
		$this->info = array();
		$this->dir = 'Programs/Web/';
		$this->name = 'WEB';
	}
}
?>