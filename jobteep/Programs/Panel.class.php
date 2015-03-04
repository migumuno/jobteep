<?php
include_once 'Programs/Program.class.php';

class Panel extends Program {
	
	function Panel() {
		$this->info = array();
		$this->dir = 'Programs/Panel/';
		$this->name = 'PANEL';
		$this->menu = array(
			"new_experience" => "Experiencia",
			"experience" => "Experiencia",
			"new_language" => "Idiomas",
			"language" => "Idiomas",
			"new_skill" => "Habilidades",
			"skill" => "Habilidades"
		);
	}
	
	public function getMenu() {
		$found = false;
		foreach ($this->menu as $k => $v) {
			if ($k == $this->page)
				$found = true;
		}
		if ($found)
			return $this->menu[$this->page];
		else 
			return 'Bienvenido';
	}
	
	public function printPage() {
		$controller = $_SESSION['SO']->getController();
		$state = $controller->getStateUser();
		if ($state == UNLOCK_STATE)
			return parent::printPage();
		else if ($state == INTRO_STATE) {
			$page = 'intro';
			$this->setPage($page);
			return $this->dir . $this->info['layout'];
		}
		else if ($state == WAITING_STATE)
			header ("Location: http://www.jobteep.com/main.php");
	}
}
?>