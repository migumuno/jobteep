<?php
include_once 'Model/Collection.class.php';
include_once 'Model/Instructions/Elements/DeleteElement.class.php';
include_once 'Model/Instructions/Elements/InsertElement.class.php';
include_once 'Model/Instructions/Elements/SelectAllElements.class.php';
include_once 'Model/Instructions/Elements/SelectElement.class.php';
include_once 'Model/Instructions/Elements/UpdateElement.class.php';


class InstructionParser {
	private $collection;
	
	function InstructionParser() {
		$this->collection = new Collection();
		$this->collection->addItem(new InsertElement(), "insertElement");
		$this->collection->addItem(new UpdateElement(), "updateElement");
		$this->collection->addItem(new DeleteElement(), "deleteElement");
		$this->collection->addItem(new SelectElement(), "selectElement");
		$this->collection->addItem(new SelectAllElements(), "selectAllElements");
	}
	
	public function parser ($key) {
		try {
			return $this->collection->getItem($key);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
}
?>