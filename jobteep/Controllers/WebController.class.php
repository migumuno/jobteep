<?php
include_once 'Controllers/Controller.interface.php';

class WebController implements Controller {
	
	public function executeAction () {
		$action = $_GET['action'];
		switch ($action) {
			case "login":
				$this->login();
				break;
			case "adminlogin":
				$this->adminlogin();
				break;
			case "applogin":
				$this->applogin();
				break;
			case "logout":
				$this->logout();
				break;
			case "adminlogout":
				$this->adminlogout();
				break;
			case "applogout":
				$this->applogout();
				break;
			case "register":
				$this->register();
				break;
			case "adminregister":
				$this->adminregister();
				break;
			case "confirm":
				$this->confirmEmail();
				break;
			case "passRecover":
				$this->passRecover();
				break;
			case "changePass":
				$this->changePass();
				break;
			case "changed":
				$this->changed();
				break;
		}
	}
	
	private function login () {
		$this->logout($exit = false);
		$_SESSION['SO']->setBBDD('PANEL');
		if ($_SESSION['SO']->login($_POST))
			header('Location: /main.php?program=panel');
	}
	
	private function adminlogin () {
		$this->adminlogout($exit = false);
		$_SESSION['SO']->setBBDD('ADMIN');
		if ($_SESSION['SO']->adminlogin($_POST))
			header('Location: /main.php?program=brain');
	}
	
	private function applogin () {
		$this->adminlogout($exit = false);
		$_SESSION['SO']->setBBDD('ADMIN');
		if ($_SESSION['SO']->applogin($_POST))
			header('Location: /main.php?program=admin');
	}
	
	public function getNumUsers () {
		return $_SESSION['SO']->numUsers();
	}
	
	public function getNumTweets () {
		$getfield = '?screen_name=jobteep';
		$requestMethod = 'GET';
		$json = $_SESSION['SO']->getTweets ($getfield, $requestMethod);
		$json = json_decode($json);
		return count($json->statuses);
	}
	
	public function logout ($exit = true) {
		$_SESSION['SO']->logout($exit);
	}
	
	public function adminlogout ($exit = true) {
		$_SESSION['SO']->adminlogout($exit);
	}
	
	public function applogout ($exit = true) {
		$_SESSION['SO']->applogout($exit);
	}
	
	public function userExist($user) {
		$_SESSION['SO']->setBBDD('PANEL');
		return $_SESSION['SO']->userExist($user);
	}
	
	public function register () {
		$_SESSION['SO']->setBBDD('PANEL');
		$_SESSION['SO']->register($_POST);
	}
	
	public function adminregister () {
		$_SESSION['SO']->setBBDD('ADMIN');
		$_SESSION['SO']->adminregister($_POST);
	}
	
	public function confirmEmail () {
		$_SESSION['SO']->setBBDD('PANEL');
		if ($_SESSION['SO']->confirmEmail($_GET['key']))
			header('Location: /main.php?program=panel');
	}
	
	public function passRecover () {
		$_SESSION['SO']->setBBDD('PANEL');
		$_SESSION['SO']->passRecover($_POST['user']);
	}
	
	public function changePass () {
		$_SESSION['SO']->setBBDD('PANEL');
		$_SESSION['SO']->changePass($_POST['key'], $_POST['pass'], $_POST['pass2']);
	}
	
	public function changed () {
		SO::$ALERT = true;
		SO::$MESSAGE = "Introduce tu nueva contraseña para cambiarla.";
	}
}