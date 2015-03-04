<?php
include_once 'Model/Instructions/Elements/MC/MCElementsInstructions.class.php';

class DeleteMC extends MCElementsInstructions {
	
	
	public function execute($obj) {
		$enum = $obj->getEnum();
		try {
			$collection = $_SESSION['SO']->load($enum);
			$collection->removeItem($obj->getId());
			$_SESSION['SO']->erase($enum);
			$_SESSION['SO']->store($collection, $enum);
			return true;
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
}
?>