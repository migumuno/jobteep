<?php
include_once 'Model/Checks/Field/IsA/ChkIsA.class.php';

class ChkDateIsA extends ChkIsA {
	
	public function check() {
		$date = date_parse_from_format("d/m/Y", $this->value);
		if (checkdate ( $date['month'] , $date['day'] , $date['year'] ))
			return true;
		else
			return false;
	}
}
?>