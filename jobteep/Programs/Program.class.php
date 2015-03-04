<?php

abstract class Program {
	protected $info;
	protected $dir;
	protected $menu;
	protected $name;
	public $page;

	public function whoIAm () {
		echo 'My name is '.$this->name.'<br>';
	}
	
	public function findPage ($xml, $page) {
		$found = false;
		foreach ($xml->page as $item) {
			if ($item->name == $page) {
				$found = true;
				foreach ($item->children() as $child) {
					$this->info[$child->getName()] = $child;
				}
			}
		}
		
		return $found;
	}

	protected function setPage($page) {
		$found = false;
		if (is_null($page))
			$page = 'default';
		$xml=simplexml_load_file($this->dir . 'map.xml');
		if (!$xml) {
			
		} else {
			if ($this->findPage($xml, $page))
				$found = true;
			else {
				if ($this->findPage($xml, 'error'))
					$found = true;
			}
		}
		
		return $found;
	}
	
	public function printPage() {
		if (isset($_GET['menu'])) {
			$page = $_GET['menu'];
			$this->page = $_GET['menu'];
		} else { 
			$page = null;
			$this->page = 'Bienvenido';
		}
		if ($this->setPage($page))
			return $this->dir . $this->info['layout'];
		else 
			return '/';
	}
	
	public function getInfo ($element) {
		return $this->info[$element];
	}
	
	public function getDir () {
		return $this->dir;
	}
}
?>