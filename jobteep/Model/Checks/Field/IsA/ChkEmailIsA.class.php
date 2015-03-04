<?php
include_once 'Model/Checks/Field/IsA/ChkIsA.class.php';

class ChkEmailIsA extends ChkIsA {
	
	public function check() {
		if(filter_var($this->value, FILTER_VALIDATE_EMAIL))
			return true;
		else
			return false;
	}
}
?>