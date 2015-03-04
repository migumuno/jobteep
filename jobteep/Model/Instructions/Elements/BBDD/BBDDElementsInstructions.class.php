<?php
include_once 'Model/Instructions/Instruction.interface.php';

abstract class BBDDElementsInstructions implements Instruction {
	protected $controller;
	
	abstract public function execute ($obj);
}
?>