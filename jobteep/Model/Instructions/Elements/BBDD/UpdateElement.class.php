<?php
include_once 'Model/Instructions/Elements/BBDD/BBDDElementsInstructions.class.php';

class UpdateElement extends BBDDElementsInstructions {
	
	
	//El objeto debe tener el id guardado.
	public function execute ($obj) {
		$this->controller = $_SESSION['SO']->getController();
	
		//Obtener datos del objeto.
	
		$from = $obj->getEnum();
		$fields = array();
		$values = array();
		$where = 'id_'.$from.' = '.$obj->getId();
		
		$element = $obj->getValues();
		foreach ($element as $k => $v) {
			$fields[] = $k;
			$values[] = $v;
		}
		
		
		
		try {
			$this->controller->update ($from, $fields, $values, $where);
			$this->controller->updateElementCache($obj, $from);
			return true;
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
}
?>