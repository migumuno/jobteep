<?php
include_once 'Model/Instructions/Instruction.interface.php';
include_once 'Model/Collection.class.php';

class SelectAllElements implements Instruction {
	
	
	public function execute ($obj) {
		//Obtener datos del objeto.
	
		$enum = $obj->getEnum();
		$where = "id_user = ".$obj->get('id_user');
		$order = $obj->getOrder();
		try {
			//COMPROBAR SI ESTÁ DISPONIBLE EN LA CACHÉ 
			$collection = $_SESSION['SO']->load($enum);
			if ($collection->length() == 0) {
				//CARGAR EN LA CACHÉ
				if ($obj->isField('version')) {
					$version = $_SESSION['SO']->loadRAM ('version');
					$where = $where . ' AND version = '.$version;
				}
				$result = $_SESSION['SO']->select($enum, "*", $where, null, null, $order);
				$element = $_SESSION['SO']->getElement($enum);
				for ($i = 0; $i < $result->num_rows; $i++) {
					$result->data_seek($i);
					$row = $result->fetch_assoc();
					$new = clone $element;
					try {
						$new->setN($row);
					} catch (Exception $e) {
						throw new Exception($e->getMessage());
					}
					$new->setId($row['id_'.$enum]);
					//INSERTO EN LA COLECCIÓN
					$collection->addItem($new, $new->getId());
				}
			}
			
			return clone $collection;
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
}
?>