<?php
include_once 'Model/Instructions/Elements/BBDD/BBDDElementsInstructions.class.php';

class InsertElement extends BBDDElementsInstructions {
	
	
	public function execute ($obj) {
		//Obtener datos del objeto.
		$from = $obj->getEnum();
		$fields = array();
		$values = array();
		
		$element = $obj->getValues();
		foreach ($element as $k => $v) {
			$fields[] = $k;
			$values[] = $v;
		}
		
		try {
			$id = $_SESSION['SO']->insert($from, $fields, $values);
			if ($id != 0) {
				$obj->setId($id);
				return $obj;
			} else 
				return false;
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
}
?>