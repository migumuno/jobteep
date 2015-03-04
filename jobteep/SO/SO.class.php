<?php
include_once 'Model/BBDD.class.php';
include_once 'Model/Stack.class.php';
include_once 'Model/MC.class.php';
include_once 'Model/RAM.class.php';
include_once 'SO/Security/Security.class.php';
include_once 'SO/Communications/Email.class.php';
include_once 'SO/Communications/Location.class.php';
include_once 'SO/Apis/Fbk.class.php';
include_once 'SO/Apis/Twitter.class.php';
include_once 'Controllers/PanelController.class.php';
include_once 'Controllers/ProfileController.class.php';
include_once 'Controllers/WebController.class.php';
include_once 'Controllers/BrainController.class.php';
include_once 'Controllers/AdminController.class.php';
include_once 'Model/Checks/CheckParser.class.php';
include_once 'Model/Elements/ElementParser.class.php';
include_once 'Model/Instructions/InstructionParser.class.php';
include_once 'Programs/Web.class.php';
include_once 'Programs/Panel.class.php';
include_once 'Programs/Profile.class.php';
include_once 'Programs/Admin.class.php';
include_once 'Programs/BrainProgram.class.php';
include_once 'SO/Exceptions/SO/GeneralException.exception.php';


class SO {
	private $BBDD;
	private $stack;
	private $MC;
	private $RAM;
	private $mail;
	private $location;
	private $facebook;
	private $twitter;
	private $security;
	private $parsers;
	private $controllers;
	private $program;
	public static $ALERT;
	public static $MESSAGE;
	
	function SO() {
		$this->BBDD = new BBDD('panel');
		$this->stack = new Stack();
		$this->MC = new MC();
		$this->RAM = new RAM();
		$this->mail = new Email();
		$this->location = new Location();
		$this->facebook = new Fbk();
		$this->twitter = new TwitterAPIExchange();
		$this->security = new Security();
		$this->parsers = new Collection();
		$this->controllers = new Collection();
		$this->setController(new PanelController(), 'PANEL');
		$this->setController(new WebController(), 'WEB');
		$this->setController(new ProfileController(), 'PROFILE');
		$this->setController(new BrainController(), 'BRAIN');
		$this->setController(new AdminController(), 'ADMIN');
		$this->setParser(new CheckParser(), 'check');
		$this->setParser(new InstructionParser(), 'instruction');
		SO::$ALERT = false;
		SO::$MESSAGE = '';
	}
	
	public function sayHello() {
		echo 'Hi!';
	}
	
	//FUNCIONES DE LA MEMORIA CACHÉ
	
	public function store ($obj, $key) {
		try {
			$this->MC->store($obj, $key);
		} catch (Exception $e) {
			$this->onError($e->getMessage());
		}
	}
	
	public function load ($key) {
		try {
			return $this->MC->load($key);
		} catch (Exception $e) {
			$this->onError($e->getMessage());
		}
	}
	
	public function erase ($key) {
		try {
			$this->MC->erase($key);
		} catch (Exception $e) {
			$this->onError($e->getMessage());
		}
	}
	
	public function resetCache () {
		$this->MC = new MC();
	}
	
	public function getEnums () {
		return $this->MC->enums;
	}
	
	//FUNCIONES DE LA RAM
	
	public function saveRAM ($obj, $key) {
		try {
			$this->RAM->store($obj, $key);
		} catch (Exception $e) {
			$this->onError($e->getMessage());
		}
	}
	
	public function loadRAM ($key) {
		try {
			return $this->RAM->load($key);
		} catch (Exception $e) {
			$this->onError($e->getMessage());
		}
	}
	
	public function eraseRAM ($key) {
		try {
			$this->RAM->erase($key);
		} catch (Exception $e) {
			$this->onError($e->getMessage());
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
			$this->onError($e->getMessage());
		}
	}
	
	//FUNCIONES BASE DE DATOS
	
	public function select ($from, $fields = "*", $where = null, $group = null, $having = null, $order = null) {
		try { 
			return $this->BBDD->select ($from, $fields, $where, $group, $having, $order);
		} catch (Exception $e) {
			$this->onError($e->getMessage());
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
			return $this->BBDD->update ($from, $fields, $values, $where);
		} catch (Exception $e) {
			$this->onError($e->getMessage());
		}
	}
	
	public function delete ($from, $where) {
		try {
			$this->BBDD->delete ($from, $where);
		} catch (Exception $e) {
			$this->onError($e->getMessage());
		}
	}
	
	//FUNCIONES COMUNICACIÓN
	
	public function sendMail ($subject, $body, $recipients, $altBody = null, $attachment = null, $cc = null, $bcc = null) {
		try {
			$mail = clone $this->mail;
			$mail->sendMail($subject, $body, $recipients, $altBody, $attachment, $cc, $bcc);
		} catch (Exception $e) {
			$this->onError($e->getMessage());
		}
	}
	
	public function setParamsLocation ($direction) {
		$loc = clone $this->location;
		$loc->setParams($direction);
		return $loc;
	}
	
	//APIS
	
	public function getUrlFbk ($api) {
		$this->facebook->setParams($api);
		return $this->facebook->getUrl();
	}
	
	public function getInfoFbk () {
		return $this->facebook->getInfoUser();
	}
	
	public function getItemFbk ($item) {
		return $this->facebook->getItem($item);
	}
	
	public function getFriends () {
		return $this->facebook->getFriends();
	}
	
	public function getFbkId () {
		return $this->facebook->getIdUser ();
	}
	
	public function setParamsFbk ($params) {
		$this->facebook->setParams($params);
	}
	
	public function getTweets ($getfield, $requestMethod) {
		$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
		$json = $this->twitter->setGetfield($getfield)
				->buildOauth($url, $requestMethod)
				->performRequest();
		return $json;
	}
	
	//FUNCIONES SEGURIDAD
	
	/**
	 * Devuelve el id_user.
	 */
	public function getUID ($program = null) {
		if (is_null($program))
			$program = $this->program;
		return $this->security->getUID($program);
	}
	
	/**
	 * Devuelve el nombre del administrador registrado.
	 */
	public function getAdminName () {
		return $this->security->getAdminName();
	}
	
	/**
	 * OBSOLETE, USE getUserInfo().
	 */
	public function getName () {
		return $this->security->getName($this->program);
	}
	
	public function getUserInfo ($param) {
		return $this->security->getUserInfo($param);
	}
	
	public function login ($values) {
		try {
			$this->security->login($values);
			$this->saveRAM(0, 'version');
			return true;
		} catch (Exception $e) {
			$this->onError($e->getMessage());
			return false;
		}
	}
	
	public function adminlogin ($values) {
		try {
			$this->security->adminlogin($values);
			return true;
		} catch (Exception $e) {
			$this->onError($e->getMessage());
			return false;
		}
	}
	
	public function applogin ($values) {
		try {
			$this->security->applogin($values);
			return true;
		} catch (Exception $e) {
			$this->onError($e->getMessage());
			return false;
		}
	}
	
	public function logout ($exit = true) {
		$this->MC = new MC();
		$this->RAM = new RAM();
		$this->stack = new Stack();
		$this->security->logout($exit);
	}
	
	public function adminlogout ($exit = true) {
		$this->security->adminlogout($exit);
	}
	
	public function applogout ($exit = true) {
		$this->security->applogout($exit);
	}
	
	public function userExist ($user) {
		return $this->security->userExist($user);
	}
	
	public function register ($values) {
		try {
			$this->security->register($values);
			return true;
		} catch (Exception $e) {
			$this->onError($e->getMessage());
			return false;
		}
	}
	
	public function adminregister ($values) {
		try {
			$this->security->adminregister($values);
			return true;
		} catch (Exception $e) {
			$this->onError($e->getMessage());
			return false;
		}
	}
	
	public function confirmEmail ($key) {
		try {
			$this->security->confirmEmail($key);
			return true;
		} catch (Exception $e) {
			$this->onError($e->getMessage());
			return false;
		}
	}
	
	public function passRecover ($user) {
		try {
			$this->security->passRecover($user);
			return true;
		} catch (Exception $e) {
			$this->onError($e->getMessage());
			return false;
		}
	}
	
	public function changePass ($key, $pass, $pass2) {
		try {
			$this->security->changePass($key, $pass, $pass2);
			return true;
		} catch (Exception $e) {
			$this->onError($e->getMessage());
			return false;
		}
	}
	
	public function grantAccess () {
		if (!$this->security->checkAccess())
			return false;
		else
			return true;
	}
	
	//FUNCIONES PROGRAMAS
	
	private function setProgram () {
		if (isset ($_GET['domain'])) {
			$this->setBBDD('PANEL');
			$this->program = 'PROFILE';
			$where = 'domain = "'.$_GET['domain'].'"';
			$result = $this->select("info", "*", $where);
			if ($result->num_rows == 0) {
				/*$this->program = 'WEB';
				return new Web();*/
				header('Location: /');
			} else {
				$yeha = $result->fetch_assoc();
				$where = "id_user = ".$yeha['id_user'];
				$result2 = $this->select("settings", "*", $where);
				$settings = $result2->fetch_assoc();
				if ($this->getUID('PANEL') == $yeha['id_user'])
					return new Profile($settings['template']);
				else {
					if ($settings['public'])
						return new Profile($settings['template']);
					else {
						$this->program = 'WEB';
						return new Web();
					}
				}
			}
		} else if (isset ($_GET['program']) && ($_GET['program'] == 'panel')) {
			$this->program = 'PANEL';
			return new Panel();
		} else if (isset ($_GET['program']) && ($_GET['program'] == 'brain')) {
			$this->program = 'BRAIN';
			return new BrainProgram();
		} else if (isset ($_GET['program']) && ($_GET['program'] == 'admin')) {
			$this->program = 'ADMIN';
			return new Admin();
		} else {
			$this->program = 'WEB';
			return new Web();
		}
	}
	
	public function openProgram () {
		$program = $this->setProgram();
		$this->security->setProgram($this->program);
		if (!$this->security->checkAccess()) {
			$this->onError("Acceso denegado, para poder acceder necesitas loguearte.");
			header('Location: /main.php');
		} else {
			return $program;
		}
	}
	
	public function getStateUser () {
		$where = 'id_user = '.$this->getUID();
		$result = $this->select('user', '*', $where);
		$row = $result->fetch_assoc();
		return $row['state'];
	}
	
	public function changeState ($state) {
		$fields = array('state');
		$values = array($state);
		$where = 'id_user = '.$this->getUID();
		$this->update('user', $fields, $values, $where);
	}
	
	public function domainExist ($domain) {
		$where = 'domain = "'.$domain.'"';
		$result = $this->select('info', '*', $where);
		if ($result->num_rows == 0)
			return false;
		else 
			return true;
	}
	
	//FUNCIONES SISTEMA OPERATIVO
	
	public function start () {
		$this->setParser(new ElementParser(), 'element');
	}
	
	public function printAccess ($program) {
		$accessPass = $this->security->getAccessPass();
		return $accessPass[$program]['access'];
	}
	
	public function openAccess ($program) {
		$this->security->openAccess($program);
	}
	
	public function setController ($controller, $key) {
		$this->controllers->addItem($controller, $key);
	}
	
	public function getController () {
		try {
			return $this->controllers->getItem($this->program);
		} catch (Exception $e) {
			$this->onError($e->getMessage());
		}
	}
	
	public function setParser ($parser, $key) {
		$this->parsers->addItem($parser, $key);
	}
	
	public function getParser ($key) {
		try {
			return $this->parsers->getItem($key);
		} catch (Exception $e) {
			$this->onError($e->getMessage());
		}
	}
	
	public function getInstruction ($instr) {
		$parser = $this->getParser('instruction');
		return $parser->parser($instr);
	}
	
	public function getElement($element) {
		$parser = $this->getParser('element');
		return $parser->parser($element);
	}
	
	public function setBBDD ($bbdd) {
		switch ($bbdd) {
			case "PANEL":
				$this->BBDD = new BBDD('panel');
				break;
			case "ADMIN":
				$this->BBDD = new BBDD('admin');
				break;
			case "DATA":
				$this->BBDD = new BBDD('data');
				break;
			case "TEMPLATE":
				$this->BBDD = new BBDD('template');
		}
	}
	
	public function executeInstruction ($instruction, $obj) {
		try {
			$instr = $this->getInstruction($instruction);
			return $instr->execute ($obj);
		} catch (Exception $e) {
			$this->onError($e->getMessage());
			return false;
		}
	}
	
	public function onError ($error) {
		SO::$ALERT = true;
		SO::$MESSAGE = $error;
	}
	
	public function numUsers () {
		$from = "user";
		$_SESSION['SO']->setBBDD('PANEL');
		$result = $_SESSION['SO']->select ($from, '*');
		return $result->num_rows;
	}
}
?>