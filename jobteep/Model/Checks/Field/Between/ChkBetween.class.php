<?php
require_once '../ChkField.class.php';

abstract class ChkBetween extends ChkField {
	protected $lim_inf;
	protected $lim_sup;
	
	abstract public function check ();
	
	public function executeCheck() {
		$controller = $_SESSION[Main::$CURRENT_VIEW]->getController();
		$this->lim_inf = $controller->pop();
		$this->lim_sup = $controller->pop();
		$this->check();
	}
}
?>