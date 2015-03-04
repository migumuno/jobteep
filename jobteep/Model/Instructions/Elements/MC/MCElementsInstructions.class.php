<?php
include_once 'Model/Instructions/Instruction.interface.php';
include_once 'Model/Collection.class.php';

abstract class MCElementsInstructions implements Instruction {
	protected $controller;
	
	abstract public function execute ($obj);
}
?>