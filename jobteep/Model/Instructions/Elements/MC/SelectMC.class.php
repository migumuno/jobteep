<?php
include_once 'Model/Instructions/Elements/MC/MCElementsInstructions.class.php';

class SelectMC extends MCElementsInstructions {
	
	
	public function execute($obj) {
		$enum = $obj->getEnum();
		$key = $obj->getId();
		$controller = $_SESSION[Main::$CURRENT_VIEW]->getController();
		return $element = $controller->selectElement ($enum, $key);
	}
}
?>