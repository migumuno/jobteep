<?php
require_once 'ChkIsA.class.php';

class ChkNotEmptyIsA extends ChkIsA {
	
	public function check() {
		if ($this->value != "")
			return true;
		else
			return false;
	}
}
?>