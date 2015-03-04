<?php
include_once 'Model/Instructions/Instruction.interface.php';
include_once 'Model/Collection.class.php';

class InsertElement implements Instruction {
	
	
	public function execute ($obj) {
		//Obtener datos del objeto.
		$enum = $obj->getEnum();
		$fields = array();
		$values = array();
		
		$element = $obj->getValues();
		foreach ($element as $k => $v) {
			$fields[] = $k;
			$values[] = $v;
		}
		
		try {
			//INSERTO EN LA BBDD
			$id = $_SESSION['SO']->insert($enum, $fields, $values);
			//ACTUALIZO LA MC
			$obj->setId($id);
			$collection = $_SESSION['SO']->load($enum);
			$collection->addItem($obj, $id);
			return $id;
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
}
?>