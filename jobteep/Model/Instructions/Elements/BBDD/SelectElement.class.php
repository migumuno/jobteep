<?php
include_once 'Model/Instructions/Elements/BBDD/BBDDElementsInstructions.class.php';

class SelectElement extends BBDDElementsInstructions {
	
	
	//SI FALLA HAY QUE LLAMAR A SelectAllElements() PARA QUE REELENE LOS ELEMENTOS Y DESPUÉS
	//VOLVER A INTENTARLO
	public function execute ($obj) {
		$this->controller = $_SESSION['SO']->getController();
	
		$from = $obj->getEnum();
		$where = 'id_'.$from.' = '.$obj->getId();
		
		try {
			return $element = $this->controller->selectElement ($from, $obj->getId);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
}
?>