<?php
include_once 'BBDD.class.php';
include_once 'MC.class.php';
include_once 'Stack.class.php';

class CPU {
	private $BBDD;
	private $stack;
	private $MC;
	
	function CPU() {
		$this->BBDD = new BBDD('panel');
		$this->stack = new Stack();
		$this->MC = new MC();
	}
	
	//FUNCIONES DE LA MEMORIA CACHÉ
	
	public function store ($obj, $key) {
		try {
			$this->MC->store($obj, $key);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
	
	public function load ($key) {
		try {
			return $this->MC->load($key);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
			return null;
		}
	}
	
	public function erase ($key) {
		try {
			$this->MC->erase($key);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
	
	//FUNCIONES DE LA PILA
	
	public function push ($element) {
		$this->stack->stackElement($element);
	}
	
	public function pop () {
		try {
			return $this->stack->unstack();
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
	
	//FUNCIONES BASE DE DATOS
	
	public function select ($from, $fields = "*", $where = null, $group = null, $having = null, $order = null) {
		try {
			$this->BBDD->select ($from, $fields, $where, $group, $having, $order);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
	
	public function insert ($from, $fields, $values) {
		try {
			return $this->BBDD->insert ($from, $fields, $values);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
	
	public function update ($from, $fields, $values, $where) {
		try {
			$this->BBDD->update ($from, $fields, $values, $where);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
	
	public function delete ($from, $where) {
		try {
			$this->BBDD->delete ($from, $where);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
}
?>