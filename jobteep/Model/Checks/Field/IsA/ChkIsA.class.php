<?php
include_once 'Model/Checks/Field/ChkField.class.php';

abstract class ChkIsA extends ChkField {
	
	abstract public function check();
	
	public function executeCheck() {
		return $this->check();
	}
}
?>