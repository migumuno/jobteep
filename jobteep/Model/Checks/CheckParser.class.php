<?php
include_once 'Model/Collection.class.php';
include_once 'Model/Checks/Field/IsA/ChkEmailIsA.class.php';
include_once 'Model/Checks/Field/IsA/ChkIntIsA.class.php';
include_once 'Model/Checks/Field/IsA/ChkNotEmptyIsA.class.php';
include_once 'Model/Checks/Field/IsA/ChkTelfIsA.class.php';
include_once 'Model/Checks/Field/IsA/ChkDateIsA.class.php';
include_once 'Model/Exceptions/Checks/IncorrectCheckException.exception.php';
include_once 'Model/Exceptions/Checks/IncorrectValueException.exception.php';
include_once 'Model/Exceptions/Checks/IncorrectValueNullException.exception.php';
include_once 'Model/Exceptions/Checks/ValueEmptyException.exception.php';

class CheckParser {
	private $collection;
	
	function CheckParser() {
		$this->collection = new Collection();
		$this->collection->addItem(new ChkEmailIsA(), "email");
		$this->collection->addItem(new ChkIntIsA(), "int");
		$this->collection->addItem(new ChkNotEmptyIsA(), "notEmpty");
		$this->collection->addItem(new ChkTelfIsA(), "telf");
		$this->collection->addItem(new ChkDateIsA(), 'date');
	}
	
	public function parser ($check, $value) {
		if ($value != null) {
			if (substr($check, 0, 4) == "file") {
				$key = $check;
				if ($this->collection->exists($key))
					return $this->collection->getItem($key);
				else {
					throw new IncorrectCheckException("El chequeo introducido: ". $check ." no es correcto.");
					return null;
				}
			} else {
				if ($value = "") {
					if ($this->checker->beNull($check)) {
						throw new ValueEmptyException("El valor introducido está vacío y está permitido.");
						return null;
					} else {
						throw new IncorrectValueException("El valor introducido no es correcto.");
						return null;
					}
				} else {
					if ($this->beNull($check))
						$key = substr($check, 0, -1);
					else 
						$key = $check;
					if ($this->collection->exists($key))
						return $this->collection->getItem($key);
					else {
						throw new IncorrectCheckException("El chequeo introducido: ". $check ." no es correcto.");
						return null;
					}
				}
			}
		} else {
			throw new IncorrectValueNullException("El valor introducido en el campo ". $check ." no puede ser nulo.");
			return null;
		}
	}
	
	public function beNull ($check) {
		$aux = str_split($check);
		if (strcmp($aux[count($aux)-1], "N") == 0)
			return true;
		else
			return false;
	}
}
?>