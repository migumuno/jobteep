<?php
include_once 'Model/Checks/Check.interface.php';

abstract class ChkField implements Check {
	protected $value;
	
	abstract public function executeCheck();
	
	public function execute ($value) {
		$this->value = $value;
		return $this->executeCheck();
	}
}
?>