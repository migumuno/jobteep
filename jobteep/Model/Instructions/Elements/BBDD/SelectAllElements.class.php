<?php
include_once 'Model/Instructions/Elements/BBDD/BBDDElementsInstructions.class.php';

class SelectAllElements extends BBDDElementsInstructions {
	
	
	public function execute ($obj) {
		$this->controller = $_SESSION['SO']->getController();
	
		//Obtener datos del objeto.
	
		$from = $obj->getEnum();
		$where = "id_user = ".$this->controller->getId();
		$order = $obj->getOrder();
		
		try {
			$coll = $this->controller->selectCollection ($from);
			if ($coll->length() == 0) {
				$result = $this->controller->select($from, "*", $where, null, null, $order);
				$parser = $this->controller->getParser('element');
				for ($i = 0; $i < $result->num_rows(); $i++) {
					$result->data_seek($i);
					$row = $result->fetch_assoc();
					
					//Crear un nuevo objeto del tipo adecuado (parser)
					$obj = $parser->parser($from);
					
					//Rellenar el objeto
					foreach ($row as $k => $v) {
						if ($k != "id_".$from)
							$obj->set($k, $v);
						else 
							$obj->setId($v);
					}
					
					//Añadir el objeto a la colección correspondiente
					$this->controller->insertElementCache($obj, $from);
				}
				
			}
			
			return $this->controller->selectCollection($from);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
}
?>