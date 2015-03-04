<?php
include_once 'Programs/Program.class.php';

class BrainProgram extends Program {
	
	function BrainProgram() {
		$this->info = array();
		$this->dir = 'Programs/Brain/';
		$this->name = 'BRAIN';
	}
}
?>