<?php
include_once 'Model/Instructions/Instruction.interface.php';
include_once 'Model/Collection.class.php';

class DeleteElement implements Instruction {
	
	
	public function execute ($obj) {
		//Obtener datos del objeto.
	
		$enum = $obj->getEnum();
		$where = 'id_'.$enum.' = '.$obj->getId();
	
		try {
			//BORRO DE LA BASE DE DATOS
			$_SESSION['SO']->delete($enum, $where);
			//BORRO DE LA MC
			$collection = $_SESSION['SO']->load($enum);
			$collection->removeItem($obj->getId());
			return true;
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
}
?>