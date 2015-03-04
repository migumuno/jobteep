<?php
require_once 'Model/Checks/Check.interface.php';

abstract class ChkFile implements Check {
	protected $file;
	protected $name;
	protected $enum;
	protected $id_user;
	protected $types;
	protected $max_size;
	protected $dir;
	protected $file_dir;
	protected $allowed_ext;
	
	protected function checkName() {
		if ($this->file[$this->name]['name'] != "") {
			if(file_exists($this->file_dir))
				return false;
			else
				return true;
		} else
			return false;
	}
	
	protected function checkSize() {
		if($this->file[$this->name]['size'] > $this->max_size)
			return false;
		else
			return true;
	}
	
	protected function checkError() {
		if($this->file[$this->name]['error'] > 0)
			return false;
		else
			return true;
	}
	
	protected function checkType() {
		$temp = explode(".", $this->file[$this->name]['name']);
		$extension = end($temp);
		if (in_array($this->file[$this->name]['type'], $this->types) && in_array($extension, $this->allowed_ext))
			return true;
		else
			return false;
	}
	
	abstract public function check ();
	
	public function execute ($value) {
		$this->file = $value;
		$controller = $_SESSION[Main::$CURRENT_VIEW]->getController();
		$this->name = $controller->pop();
		$this->enum = $controller->pop();
		$this->id_user = $controller->getId();
		$this->check();
	}
}
?>