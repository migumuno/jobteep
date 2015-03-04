<?php
include_once 'Model/Instructions/Elements/MC/MCElementsInstructions.class.php';

class InsertMC extends MCElementsInstructions {
	
	
	public function execute($obj) {
		$enum = $obj->getEnum();
		try {
			$collection = $_SESSION['SO']->load($enum);
			$collection->addItem($obj, $obj->getId());
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
}
?>