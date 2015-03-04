<?php
include_once 'Model/Instructions/Instruction.interface.php';
include_once 'Model/Collection.class.php';

class SelectElement implements Instruction {
	
	
	//SI FALLA HAY QUE LLAMAR A SelectAllElements() PARA QUE REELENE LOS ELEMENTOS Y DESPUÉS
	//VOLVER A INTENTARLO
	public function execute ($obj) {
	
		$enum = $obj->getEnum();
		$where = 'id_'.$enum.' = '.$obj->getId();
		
		try {
			$collection = $_SESSION['SO']->load($enum);
			$element = $collection->getItem($obj->getId());
			return clone $element;
		} catch (Exception $e) {
			$result = $_SESSION['SO']->select($enum, "*", $where);
			$row = $result->fetch_assoc();
			try {
				$obj->setN($row);
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
			$obj->setId($row['id_'.$enum]);
			return $obj;
		}
	}
}
?>