<?php
define ("WAITING_STATE", 0);
define ("UNLOCK_STATE", 1);
define ("INTRO_STATE", 2);

include_once 'SO/Exceptions/Security/FailRegisterUserException.exception.php';
include_once 'SO/Exceptions/Security/FailRegisterPassException.exception.php';
include_once 'SO/Exceptions/Security/FailLoginException.exception.php';
include_once 'SO/Exceptions/Security/WaitingStateException.exception.php';
include_once 'SO/Exceptions/Security/IncorrectKeywordException.exception.php';
include_once 'SO/Exceptions/Security/ConfirmEmailOkException.exception.php';
include_once 'SO/Exceptions/Security/RegisterOkException.exception.php';
include_once 'SO/Exceptions/Security/IncorrectUserException.exception.php';
include_once 'SO/Exceptions/Security/RecoverPassOkException.exception.php';
include_once 'SO/Exceptions/Security/ChangePassOkException.exception.php';
include_once 'Model/Exceptions/Disk/CreateDirectoryFail.exception.php';

class Security {
	private $accessPass;
	private $user;
	private $admin;
	private $key;
	private $program;
	private $user_info;
	private $admin_info;
	
	function Security() {
		$this->accessPass = array(
			"WEB" => array(
				"access" => true,
				"user" => 0,
				"table" => "user",
				"program" => "PANEL",
				"admin" => "BRAIN",
				"app" => "ADMIN"
			),
			"PANEL" => array(
				"access" => false,
				"user" => 0,
				"name" => '',
				"table" => "user"
			),
			"BRAIN" => array(
				"access" => false,
				"user" => 0,
				"name" => '',
				"table" => "user"
			),
			"PROFILE" => array(
				"access" => true,
				"user" => 0,
				"name" => '',
				"table" => "user"
			),
			"ADMIN" => array(
				"access" => false,
				"user" => 0,
				"name" => '',
				"table" => "user"
			)
		);
	}
	
	public function getUID ($program) {
		return $this->accessPass[$program]['user'];
	}
	
	public function getAdminName () {
		return $this->admin;
	}
	
	public function getName ($program) {
		return $this->accessPass[$program]['name'];
	}
	
	public function getUserInfo ($param) {
		return $this->user_info[$param];
	}
	
	public function getAccessPass () {
		return $this->accessPass;
	}
	
	public function openAccess ($program) {
		$this->accessPass[$program]['access'] = true;
	}
	
	public function setProgram ($program) {
		$this->program = $program;
	}
	 
	private function crypt_blowfish($password){
		$digito = 7;
		$set_salt = './1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		$salt = sprintf('$2a$%02d$', $digito);
		for($i = 0; $i < 22; $i++){
			$salt .= $set_salt[mt_rand(0, 63)];
		}
		return crypt($password, $salt);
	}
	
	private function setKey ($add) {
		$date = date("Y-m-d");
		$time = date("H:i:s");
		$key = $date . $time . $add;
		$this->key = $this->crypt_blowfish($key);
	}
	
	private function setDomain ($user) {
		/*$digito = 4;
		$set_salt = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		$salt = sprintf('$2a$%02d$', $digito);
		for($i = 0; $i < 22; $i++){
			$salt .= $set_salt[mt_rand(0, 61)];
		}
		return crypt($user, $salt);*/
		return md5($user);
	}
	
	private function sendEmail ($type) {
		$xml = simplexml_load_file('SO/Security/EmailTemplates/emails.xml');
		foreach ($xml->email as $item) {
			if ($item->name == $type) {
				$subject = $item->subject;
				$body = $item->body;
			}
		}
		$body = file_get_contents($body);
		$body = str_replace('{keyword}', $this->key, $body);
		$recipients = array(
			$this->user => ""
		);
		$_SESSION['SO']->sendMail($subject, $body, $recipients);
		unset($recipients);
	}
	
	private function select ($where) {
		try {
			$_SESSION['SO']->setBBDD('PANEL');
			return $_SESSION['SO']->select ($this->accessPass[$this->program]['table'], "*", $where);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
	
	private function adminselect ($where) {
		try {
			$_SESSION['SO']->setBBDD('ADMIN');
			return $_SESSION['SO']->select ($this->accessPass[$this->program]['table'], "*", $where);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
	
	private function insert ($fields, $values) {
		try {
			$_SESSION['SO']->setBBDD('PANEL');
			$this->id = $_SESSION['SO']->insert($this->accessPass[$this->program]['table'], $fields, $values);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
		return true;
	}
	
	private function admininsert ($fields, $values) {
		try {
			$_SESSION['SO']->setBBDD('ADMIN');
			$this->id = $_SESSION['SO']->insert($this->accessPass[$this->program]['table'], $fields, $values);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
		return true;
	}
	
	private function update ($fields, $values, $where) {
		try {
			$_SESSION['SO']->setBBDD('PANEL');
			$_SESSION['SO']->update($this->accessPass[$this->program]['table'], $fields, $values, $where);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
	
	private function checkEmail ($email) {
		if(filter_var($email, FILTER_VALIDATE_EMAIL))
			return true;
		else
			return false;
	}
	
	public function userExist ($user) {
		$where = 'user = "'.$user.'"';
		$result = $this->select($where);
		if ($result->num_rows == 0)
			return false;
		else 
			return true;
	}
	
	public function adminExist ($user) {
		$where = 'user = "'.$user.'"';
		$result = $this->select($where);
		if ($result->num_rows == 0)
			return false;
		else 
			return true;
	}
	
	public function register ($values) {
		if (strcmp($values['pass'], $values['pass2']) == 0) {
			if ($this->checkEmail($values['user'])) {
				try {
					if (!$this->userExist($values['user'])) {
						$this->user = $values['user'];
						$this->setKey($this->user);
						$pass = $this->crypt_blowfish($values['pass']);
						$state = WAITING_STATE;
						$dir_name = $this->setDomain($this->user);
						$fields = array("user", "pass", "keyword", "state", "dir");
						$values = array($this->user, $pass, $this->key, $state, $dir_name);
						//CREO EL DIRECTORIO PARA LOS ARCHIVOS DEL USUARIO
						$save = umask(0);
						if (mkdir('Data/Users/'.$dir_name, 0775))
							umask($save);
						else {
							umask($save);
							throw new CreateDirectoryFail("Lo sentimos pero no se ha podido crear tu carpeta personal, inténtelo más tarde.");
						}
						//INSERTO EL USUARIO
						$this->insert($fields, $values);
						//CREO LOS SETTINGS DEL USUARIO
						$from = 'settings';
						$fields = array("id_user", "template");
						$values = array($this->id, "Origin");
						$_SESSION['SO']->setBBDD('PANEL');
						$_SESSION['SO']->insert ($from, $fields, $values);
						//CREO EL UPGRADE DEL USUARIO
						$from = 'upgrade';
						$fields = array("id_user");
						$values = array($this->id);
						$_SESSION['SO']->setBBDD('PANEL');
						$_SESSION['SO']->insert ($from, $fields, $values);
						$this->sendEmail('confirm');
						//INSERTO AL USUARIO EN LA BBDD DE TEMPLATES EN DEFAULT
						$from = 'origin';
						$fields = array("id_user");
						$values = array($this->id);
						$_SESSION['SO']->setBBDD('TEMPLATE');
						try {
							$_SESSION['SO']->insert ($from, $fields, $values);
						} catch (Exception $e) {
							
						}
						$_SESSION['SO']->setBBDD('PANEL');
						throw new RegisterOkException("¡Ya estás registrado/a! Te acabamos de enviar un email a tu cuenta de correo para que lo confirmes, recuerda mirar en SPAM. ¡Hasta pronto!");
					} else
						throw new FailRegisterUserException("Lo sentimos pero el usuario que has introducido no está disponible.");
				} catch (RegisterOkException $e) {
					throw new Exception ($e->getMessage());
				} catch (FailRegisterUserException $e) {
					throw new Exception ($e->getMessage());
				} catch(Exception $e) {
					$_SESSION['SO']->setBBDD('PANEL');
					$from = 'user';
					$where = 'id_user = '.$this->id;
					$_SESSION['SO']->delete($from, $where);
					if (is_dir('Data/Users/'.$dir_name))
						rmdir('Data/Users/'.$dir_name);
					throw new Exception ($e->getMessage());
				}
			} else 
				throw new FailRegisterUserException("El email introducido no es correcto, es indispensable para poder acceder a la plataforma.");
		} else
			throw new FailRegisterPassException("Las contraseñas que has introducido no coinciden, necesitamos garantizar que sabes tu contraseña.");
	}
	
	public function adminregister ($values) {
		if (strcmp($values['pass'], $values['pass2']) == 0) {
			try {
				if (!$this->adminExist($values['user'])) {
					$this->admin = $values['user'];
					$pass = $this->crypt_blowfish($values['pass']);
					$state = WAITING_STATE;
					$fields = array("user", "pass", "state");
					$values = array($this->admin, $pass, $state);
					//INSERTO EL USUARIO
					$this->admininsert($fields, $values);
					throw new RegisterOkException("¡Te has registrado correctamente!");
				} else
					throw new FailRegisterUserException("Lo sentimos pero el usuario que has introducido no está disponible.");
			} catch (RegisterOkException $e) {
				throw new Exception ($e->getMessage());
			} catch (FailRegisterUserException $e) {
				throw new Exception ($e->getMessage());
			} catch(Exception $e) {
				throw new Exception ($e->getMessage());
			}
		} else
			throw new FailRegisterPassException("Las contraseñas que has introducido no coinciden, necesitamos garantizar que sabes tu contraseña.");
	}
	
	public function login ($values) {
		try {
			$where = 'user = "'.$values['user'].'"';
			$result = $this->select($where);
			if ($result->num_rows == 0)
				throw new FailLoginException("El usuario y/o la contraseña no son correctos.");
			else {
				$this->user = $values['user'];
				$row = $result->fetch_assoc();
				$id = $row['id_user'];
				$name = $row['user'];
				$pass = $row['pass'];
				$state = $row['state'];
				$dir_name = $row['dir'];
				if (crypt($values['pass'], $pass) == $pass)
					if ($state != WAITING_STATE) {
						$this->accessPass[$this->accessPass[$this->program]['program']]['access'] = true;
						$this->accessPass[$this->accessPass[$this->program]['program']]['user'] = $id;
						$this->accessPass[$this->accessPass[$this->program]['program']]['name'] = $name;
						$this->user_info = array();
						$this->user_info['UID'] = $id;
						$this->user_info['name'] = $name;
						$this->user_info['dir'] = $dir_name;
						$where = 'id_user = '.$id;
						$info = $_SESSION['SO']->select ('info', '*', $where);
						if ($info->num_rows == 1) {
							$data = $info->fetch_assoc();
							$this->user_info['facebook'] = $data['id_fbk'];
							$this->user_info['linkedin'] = $data['id_lnkdn'];
						}
					} else {
						$this->setKey($this->user);
						$where = 'id_user = '. $id;
						$fields = array("keyword");
						$values = array($this->key);
						$this->update($fields, $values, $where);
						$this->sendEmail('confirm');
						
						throw new WaitingStateException("Es necesario que confirmes la cuenta antes de poder acceder. Te hemos enviado otro email por si perdiste el anterior, recuerda mirar en SPAM.");
					}
				else 
					throw new FailLoginException("El usuario y/o la contraseña no son correctos.");
			}
		} catch (Exception $e) {
			throw new Exception ($e->getMessage());
		}
	}
	
	public function adminlogin ($values) {
		try {
			$where = 'user = "'.$values['user'].'"';
			$result = $this->adminselect($where);
			if ($result->num_rows == 0)
				throw new FailLoginException("El usuario y/o la contraseña no son correctos.");
			else {
				$this->admin = $values['user'];
				$row = $result->fetch_assoc();
				$id = $row['id_user'];
				$name = $row['user'];
				$pass = $row['pass'];
				$state = $row['state'];
				if (crypt($values['pass'], $pass) == $pass)
					if ($state != WAITING_STATE) {
						$this->accessPass[$this->accessPass[$this->program]['admin']]['access'] = true;
						$this->accessPass[$this->accessPass[$this->program]['admin']]['user'] = $id;
						$this->accessPass[$this->accessPass[$this->program]['admin']]['name'] = $name;
						$this->admin_info = array();
						$this->admin_info['UID'] = $id;
						$this->admin_info['name'] = $name;
					} else {
						throw new WaitingStateException("Usuario desactivado.");
					}
				else 
					throw new FailLoginException("El usuario y/o la contraseña no son correctos.");
			}
		} catch (Exception $e) {
			throw new Exception ($e->getMessage());
		}
	}
	
	public function applogin ($values) {
		try {
			$where = 'user = "'.$values['user'].'"';
			$result = $this->adminselect($where);
			if ($result->num_rows == 0)
				throw new FailLoginException("El usuario y/o la contraseña no son correctos.");
			else {
				$this->admin = $values['user'];
				$row = $result->fetch_assoc();
				$id = $row['id_user'];
				$name = $row['user'];
				$pass = $row['pass'];
				$state = $row['state'];
				if (crypt($values['pass'], $pass) == $pass)
					if ($state != WAITING_STATE) {
						$this->accessPass[$this->accessPass[$this->program]['app']]['access'] = true;
						$this->accessPass[$this->accessPass[$this->program]['app']]['user'] = $id;
						$this->accessPass[$this->accessPass[$this->program]['app']]['name'] = $name;
						$this->admin_info = array();
						$this->admin_info['UID'] = $id;
						$this->admin_info['name'] = $name;
					} else {
						throw new WaitingStateException("Usuario desactivado.");
					}
				else 
					throw new FailLoginException("El usuario y/o la contraseña no son correctos.");
			}
		} catch (Exception $e) {
			throw new Exception ($e->getMessage());
		}
	}
	
	public function logout ($exit = true) {
		$this->accessPass[$this->accessPass[$this->program]['program']]['access'] = false;
		$this->accessPass[$this->accessPass[$this->program]['program']]['user'] = 0;
		if ($exit) {
			session_unset();
			session_destroy();
			session_start();
			session_regenerate_id(true);
			header('Location: main.php');
		}
	}
	
	public function adminlogout ($exit = true) {
		$this->accessPass[$this->accessPass[$this->program]['admin']]['access'] = false;
		$this->accessPass[$this->accessPass[$this->program]['admin']]['user'] = 0;
		if ($exit)
			header('Location: main.php');
	}
	
	public function applogout ($exit = true) {
		$this->accessPass[$this->accessPass[$this->program]['app']]['access'] = false;
		$this->accessPass[$this->accessPass[$this->program]['app']]['user'] = 0;
		if ($exit)
			header('Location: main.php');
	}
	
	public function confirmEmail ($key) {
		$where = 'keyword = "'.$key.'"';
		$result = $this->select($where);
		$row = $result->fetch_assoc();
		$id = $row['id_user'];
		$name = $row['user'];
		if ($result->num_rows == 1) {
			$fields = array("state");
			$values = array(INTRO_STATE);
			try{
				$this->update($fields, $values, $where);
				//Login
				$this->accessPass[$this->accessPass[$this->program]['program']]['access'] = true;
				$this->accessPass[$this->accessPass[$this->program]['program']]['user'] = $id;
				$this->accessPass[$this->accessPass[$this->program]['program']]['name'] = $name;
				$this->user_info = array();
				$this->user_info['UID'] = $id;
				$this->user_info['name'] = $name;
				$this->user_info['dir'] = $dir;
				$where = 'id_user = '.$id;
				$info = $_SESSION['SO']->select ('info', '*', $where);
				if ($info->num_rows == 1) {
					$data = $info->fetch_assoc();
					$this->user_info['facebook'] = $data['id_fbk'];
					$this->user_info['linkedin'] = $data['id_lnkdn'];
				}
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		} else
			throw new IncorrectKeywordException("La clave no es correcta, por lo que no podemos confirmar tu cuenta. Para poder conseguir una nueva, intenta loguearte y te la enviaremos por email.");
	}
	
	public function changePass ($key, $pass, $pass2) {
		if (strcmp($pass, $pass2) == 0) {
			$where = 'keyword = "'.$key.'"';
			$result = $this->select($where);
			if ($result->num_rows == 1) {
				$row = $result->fetch_assoc();
				$actual = date_create(date("Y-m-d H:i:s"));
				$peticion = date_create($row['keyDate'] .' '. $row['keyTime']);
				$diff = date_diff($actual, $peticion);
				$total = (($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i + $diff->s/60;
				if ($total < 15) {
					$cryptPass = $this->crypt_blowfish($pass);
					$fields = array("pass", "keyword", "keyDate", "keyTime");
					$values = array($cryptPass, null, null, null);
					$this->update($fields, $values, $where);
					throw new ChangePassOkException("La contraseña se ha cambiado correctamente, ya puedes acceder a la plataforma con ella.");
				} else 
					throw new IncorrectKeywordException("La clave no es correcta, por lo que no podemos cambiar tu contraseña. Para poder conseguir una nueva, vuelve a solicitarla. Te recordamos que la clave que te mandamos tiene una validez de 15 minutos.");
			} else 
				throw new IncorrectKeywordException("La clave no es correcta, por lo que no podemos cambiar tu contraseña. Para poder conseguir una nueva, vuelve a solicitarla. Te recordamos que la clave que te mandamos tiene una validez de 15 minutos.");
		} else 
			throw new FailRegisterPassException("Las contraseñas que has introducido no coinciden, necesitamos garantizar que sabes tu contraseña.");
	}
	
	public function passRecover ($user) {
		if ($this->checkEmail($user)) {
			$where = 'user = "'.$user.'"';
			$result = $this->select($where);
			if ($result->num_rows == 1) {
				$date = date("Y-m-d");
				$time = date("H:i:s");
				$this->setKey($date.$time.$user);
				$fields = array("keyword", "keyDate", "keyTime");
				$values = array($this->key, $date, $time);
				$this->update($fields, $values, $where);
				$this->user = $user;
				$this->sendEmail('recover');
				throw new RecoverPassOkException("Te acabamos de mandar un email con una clave para que puedas cambiar tu contraseña. Tiene una validez de 15 minutos.");
			} else
				throw new IncorrectUserException("El usuario introducido no es correcto.");
		} else
			throw new IncorrectUserException("El usuario introducido no es correcto.");
	}
	
	public function checkAccess () {
		if (!$this->accessPass[$this->program]['access'])
			return false;
		else 
			return true;
	}
}
?>