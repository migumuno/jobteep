<?php
include_once 'Model/Instructions/Elements/BBDD/BBDDElementsInstructions.class.php';

class DeleteElement extends BBDDElementsInstructions {
	
	
	public function execute ($obj) {
		//Obtener datos del objeto.
	
		$from = $obj->getEnum();
		$where = 'id_'.$from.' = '.$obj->getId();
	
		try {
			//BORRO DE LA BASE DE DATOS
			$_SESSION['SO']->delete($from, $where);
			return true;
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
}
?>