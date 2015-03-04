<?php
include_once 'Model/Instructions/Instruction.interface.php';
include_once 'Model/Collection.class.php';

class UpdateElement implements Instruction {
	
	
	//El objeto debe tener el id guardado.
	public function execute ($obj) {
		//Obtener datos del objeto.
		$enum = $obj->getEnum();
		$fields = array();
		$values = array();
		$where = 'id_'.$enum.' = '.$obj->getId();
		
		$element = $obj->getValues();
		foreach ($element as $k => $v) {
			$fields[] = $k;
			$values[] = $v;
		}
		
		try {
			//EDITO DE LA BBDD
			if ($_SESSION['SO']->update ($enum, $fields, $values, $where)) {
				//ACTUALIZO DE LA MC
				$collection = $_SESSION['SO']->load($enum);
				$new = $collection->getItem($obj->getId());
				foreach ($element as $k => $v) {
					$new->set($k, $v);
				}
				$collection->removeItem($obj->getId());
				$collection->addItem($new, $obj->getId());
				$_SESSION['SO']->erase($enum);
				$_SESSION['SO']->store($collection, $enum);
				return true;
			}
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
}
?>