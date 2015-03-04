<?php
include_once 'Model/Exceptions/Stack/EmptyStackException.exception.php';

class Stack {
	private $stack;
	
	function Stack() {
		$this->stack = array();
	}
	
	public function stackElement ($element) {
		$this->stack[] = $element;
	}
	
	public function unstack () {
		if ($this->stackLength() > 0) {
			$tam = $this->stackLength();
			$element = $this->stack[$tam-1];
			unset($this->stack[$tam-1]);
			return $element;
		} else
			throw new EmptyStackException("Error Stack: la pila está vacía.");
	}
	
	public function stackLength () {
		return count($this->stack);
	}
	
	public function isEmpty () {
		if ($this->stackLength() == 0)
			return true;
		else 
			return false;
	}
}
?>