<?php
require_once 'ChkIsA.class.php';

class ChkIntIsA extends ChkIsA {
	
	public function check() {
		if (is_numeric($this->value))
			return true;
		else
			return false;
	}
}
?>