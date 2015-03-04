<?php
include_once 'Controllers/Controller.interface.php';

class PanelController implements Controller {
	private $enum;
	private $id;
	private $facebook;
	private $elements_with_relations = array("education", "experience", "travel", "proyect");
	
	public function executeAction () {
		$action = $_GET['action'];
		switch ($action) {
			case "insertElement":
				$this->insertElement();
				break;
			case "updateElement":
				$this->updateElement();
				break;
			case "deleteElement":
				$this->deleteElement();
				break;
			case "configTemplate":
				$this->configTemplate();
				break;
			case "facebook":
				return $this->getInfoFbk();
				break;
			case "intro":
				$this->intro();
				break;
			case "version":
				$this->version();
				break;
			case "genVersion":
				$this->generateVersion();
				break;
		}
	}
	
	//FUNCIONES ELEMENTOS
	
	public function setEnum($enum) {
		$this->enum = $enum;
	}
	
	public function insertElement ($array = null) {
		if (!isset($array))
			$array = $_POST;
		try {
			$_SESSION['SO']->setBBDD('PANEL');
			$obj = $_SESSION['SO']->getElement($this->enum);
			$version = $_SESSION['SO']->loadRAM('version');
			if (isset($version) && $version != 0)
				$array['version'] = $version;
			$obj->setN($array);
			$id = $_SESSION['SO']->executeInstruction ('insertElement', $obj);
			$this->learnData();
			$this->id = $id;
			if (in_array($this->enum, $this->elements_with_relations))
				$this->updateRelation ();
			$this->onError('Datos insertados correctamente!');
		} catch (Exception $e) {
			$this->onError($e->getMessage());
		}
	}
	
	public function insertLinkedin ($array) {
		try {
			$_SESSION['SO']->setBBDD('PANEL');
			$obj = $_SESSION['SO']->getElement($this->enum);
			$version = $_SESSION['SO']->loadRAM('version');
			if (isset($version) && $version != 0)
				$array['version'] = $version;
			$obj->setN($array);
			$id = $_SESSION['SO']->executeInstruction ('insertElement', $obj);
			$this->onError('Datos insertados correctamente!');
		} catch (Exception $e) {
			$this->onError($e->getMessage());
		}
	}
	
	public function getUserName () {
		$_SESSION['SO']->setBBDD('PANEL');
		$where = 'id_user = '.$_SESSION['SO']->getUID();
		$result = $_SESSION['SO']->select('user', '*', $where);
		$user = $result->fetch_assoc();
		
		return $user['user'];
	}
	
	private function deleteImg ($file) {
		$user = $this->getUserName();
		$dir = $_SESSION['SO']->getUserInfo ('dir');
		unlink('Data/Users/'.$dir.'/'.$file);
		$partes = explode("-header", $file);
		if (count($partes) == 1) {
			$div = explode(".", $file);
			$aux = $div[0].'-header.'.$div[1];
			unlink('Data/Users/'.$dir.'/'.$aux);
		} else {
			$aux = $partes[0].$partes[1];
			unlink('Data/Users/'.$dir.'/'.$aux);
		}
	}
	
	private function checkFiles ($VALUES=null, $mode) {
		$enums = array("education", "language", "skill", "proyectimg", "mtlart");
		$fields = array("certificate", "certificate", "certificate", "file", "img");
		if (in_array($this->enum, $enums)) {
			$pos = array_search($this->enum, $enums);
			$obj = $this->selectSingleElement ();
			$bbdd = $obj->getValuesHtml();
			if (isset($bbdd[$fields[$pos]]) && $bbdd[$fields[$pos]] != '') {
				switch ($mode) {
					case "update":
						if (isset($VALUES[$fields[$pos]])) {
							if ($VALUES[$fields[$pos]] != $bbdd[$fields[$pos]]) {
								$this->deleteImg($bbdd[$fields[$pos]]);
							}
						}
						break;
					case "delete":
						$this->deleteImg($bbdd[$fields[$pos]]);
						break;
				}
				
			}
		}
	}
	
	public function updateElement () {
		$_SESSION['SO']->setBBDD('PANEL');
		$this->id = $_GET['id'];
		try {
			if ($this->enum == 'settings')
				$this->updateSettings();
			$obj = $_SESSION['SO']->getElement($this->enum);
			$version = $_SESSION['SO']->loadRAM('version');
			if (isset($version) && $version != 0)
				$_POST['version'] = $version;
			$obj->setId($this->id);
			$obj->setN($_POST);
			$this->checkFiles($_POST, 'update');
			$_SESSION['SO']->executeInstruction ('updateElement', $obj);
			$this->learnData();
			$this->updateRelation ();
			$this->onError('Datos actualizados correctamente!');
		} catch (Exception $e) {
			$this->onError($e->getMessage());
		}
	}
	
	private function updateSettings () {
		$secciones = array("language", "skill", "activity", "mtlculture", "mtlart", "mtlsport", "travel", "objetives");
		for ($i = 0; $i < count($secciones); $i++) {
			if (isset($_POST[$secciones[$i]]) && $_POST[$secciones[$i]] == 'on')
				$_POST[$secciones[$i]] = 1;
			else
				$_POST[$secciones[$i]] = 0;
		}
	}
	
	public function updateRelation () {
		$_SESSION['SO']->setBBDD('PANEL');
		$relations = array("skill", "language", "travel");
		$field_name = array("name", "name", "title");
		for ($r = 0; $r < count($relations); $r++) {
			$skills_bbdd = array();
			$skills_form = array();
			try {
				$skill = $_SESSION['SO']->getElement($this->enum.$relations[$r]);
				try {
					$skill->set('id_'.$this->enum, $this->id);
						
					//Obtengo todos los id del formulario y los guardo en un array.
					if (isset($_POST[$relations[$r]])) {
						for ($i = 0; $i < count($_POST[$relations[$r]]); $i++) {
							$where = $field_name[$r].' = "'.$_POST[$relations[$r]][$i].'" AND id_user = '.$_SESSION['SO']->getUID();
							$result = $_SESSION['SO']->select($relations[$r], '*', $where);
							$row = $result->fetch_assoc();
							//Busco el id en la tabla correspondiente y lo guardo en un array.
							$skills_form[] = $row['id_'.$relations[$r]];
						}
					}
						
					//Obtener lo que hay guardado en la base de datos
					$where = 'id_'.$this->enum.' = '.$this->id;
					$result = $_SESSION['SO']->select($this->enum.$relations[$r], '*', $where);
					if (isset($result->num_rows) && $result->num_rows > 0)
						$number_of_relations = $result->num_rows;
					else
						$number_of_relations = 0;
					//Comprobar los que tengo que borrar
					for ($i = 0; $i < $number_of_relations; $i++) {
						$result->data_seek($i);
						$row = $result->fetch_assoc();
						//Guardo el id de los resultados en un array.
						$skills_bbdd[$i] = $row['id_'.$relations[$r]];
						//Clono el objeto y le meto el id correspondiente.
						$obj = clone $skill;
						$obj->setId($row['id_'.$this->enum.$relations[$r]]);
						$find = false;
						//Recorro lo que viene del formulario
						for ($j = 0; $j < count($skills_form); $j++) {
							if ($skills_bbdd[$i] == $skills_form[$j])
								$find = true;
						}
						if (!$find)
							$_SESSION['SO']->executeInstruction ('deleteElement', $obj);
					}
				
					for ($i = 0; $i < count($skills_form); $i++) {
						$obj = clone $skill;
						$obj->set('id_'.$relations[$r], $skills_form[$i]);
						$find = false;
						for ($j = 0; $j < count($skills_bbdd); $j++) {
							if ($skills_form[$i] == $skills_bbdd[$j])
								$find = true;
						}
						if (!$find)
							$id = $_SESSION['SO']->executeInstruction ('insertElement', $obj);
					}
					unset($skill);
					unset($skills_bbdd);
					unset($skills_form);
				} catch (Exception $e) {
					throw new Exception ($e->getMessage());
				}
			} catch (Exception $e) {
				$this->onError($e->getMessage());
			}
		}
	}
	
	public function deleteElement () {
		$_SESSION['SO']->setBBDD('PANEL');
		$this->id = $_GET['id'];
		$obj = $_SESSION['SO']->getElement($this->enum);
		$obj->setId($this->id);
		try {
			$this->deleteRelations();
			$this->checkFiles(null, 'delete');
			$_SESSION['SO']->executeInstruction ('deleteElement', $obj);
			$this->onError('Datos eliminados correctamente.');
		} catch (Exception $e) {
			$this->onError($e->getMessage());
		}
	}
	
	public function deleteRelations () {
		$_SESSION['SO']->setBBDD('PANEL');
		$relations = array("skill", "language");
		for ($r = 0; $r < count($relations); $r++) {
			try {
				$skill = $_SESSION['SO']->getElement($this->enum.$relations[$r]);
				
				$where = 'id_'.$this->enum.' = '.$this->id;
				$result = $_SESSION['SO']->select($this->enum.$relations[$r], '*', $where);
				//Comprobar los que tengo que borrar
				for ($i = 0; $i < $result->num_rows; $i++) {
					$result->data_seek($i);
					$row = $result->fetch_assoc();
					//Clono el objeto y le meto el id correspondiente.
					$obj = clone $skill;
					$obj->setId($row['id_'.$this->enum.$relations[$r]]);
					$_SESSION['SO']->executeInstruction ('deleteElement', $obj);
				}
			} catch (Exception $e) {
				
			}
		}
	}
	
	public function selectSingleElement ($id = null) {
		if ($id == null)
			$id = $_GET['id'];
		$_SESSION['SO']->setBBDD('PANEL');
		$obj = $_SESSION['SO']->getElement($this->enum);
		$obj->setId($id);
		return $_SESSION['SO']->executeInstruction ('selectElement', $obj);
	}
	
	public function selectAllElements () {
		$_SESSION['SO']->setBBDD('PANEL');
		$obj = $_SESSION['SO']->getElement($this->enum);
		return $_SESSION['SO']->executeInstruction ('selectAllElements', $obj);
	}
	
	public function selectRelation ($id, $relation) {
		$field_name = array(
			"language" => "name",
			"skill" => "name",
			"travel" => "title"
		);
		$_SESSION['SO']->setBBDD('PANEL');
		$list = array();
		$where = 'id_'.$this->enum.' = '.$id;
		$result = $_SESSION['SO']->select($this->enum.$relation, '*', $where);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			$where = 'id_'.$relation.' = '.$row['id_'.$relation];
			$result2 = $_SESSION['SO']->select($relation, '*', $where);
			$row = $result2->fetch_assoc();
			$list[] = $row[$field_name[$relation]];
		}
		return $list;
	}
	
	public function getElements($element, $cond = null) {
		$_SESSION['SO']->setBBDD('PANEL');
		$where = 'id_user = '.$_SESSION['SO']->getUID();
		if (!is_null($cond))
			$where = $where . ' AND '.$cond;
		return $result = $_SESSION['SO']->select($element, '*', $where);
	}
	
	public function getData ($data, $where = null, $order = 'name ASC', $from = '*') {
		$_SESSION['SO']->setBBDD('DATA');
		$where = 'state = 1';
		return $result = $_SESSION['SO']->select($data, $from, $where, null, null, $order);
	}
	
	public function getTemplates ($data, $where = null, $order = 'name ASC', $from = '*') {
		$_SESSION['SO']->setBBDD('TEMPLATE');
		return $result = $_SESSION['SO']->select($data, $from, $where, null, null, $order);
	}
	
	private function checkSiteMap ($file) {
		$mb = 1048576;
		$max = 8;
		$date = date("Y-m-d");
		$now = date("Y_m_d_h_i_s");
		if (filesize($file) > ($max * $mb)) {
			//Creo el archivo comprimido
			$fp = fopen($file, "r");
			$data = fread ($fp, filesize($file));
			fclose($fp);
			$zp = gzopen('Sitemaps/Usuarios/'.$now.'.xml.gz', "w9");
			gzwrite($zp, $data);
			gzclose($zp);
			//Añado el archivo al index
			$xml = simplexml_load_file("sitemap.xml");
			$sxe = new SimpleXMLElement($xml->asXML());
			$sitemap = $sxe->addChild('sitemap');
			$sitemap->addChild('loc', 'http://www.jobteep.com/Sitemaps/Usuarios/'.$now.'.xml.gz');
			$sitemap->addChild('lastmod', $date);
			$sxe->asXML("sitemap.xml");
			//FORMATEO users.xml
			$users = new SimpleXMLElement('<urlset></urlset>');
			$users->asXML("Sitemaps/Usuarios/users.xml");
		}
	}
	
	private function addToSitemap($domain) {
		$this->checkSiteMap("Sitemaps/Usuarios/users.xml");
		$xml = simplexml_load_file("Sitemaps/Usuarios/users.xml");
		$sxe = new SimpleXMLElement($xml->asXML());
		$date = date("Y-m-d");
		$url = $sxe->addChild('url');
		$url->addChild('loc', 'http://www.jobteep.com/'.$domain);
		$url->addChild('lastmod', $date);
		$url->addChild('changefreq', 'daily');
	}
	
	public function intro () {
		if (isset($_POST['enum']) && $_POST['enum'] == 'info') {
			if (isset($_POST['description']) && $_POST['description'] != '')
				$_POST['description'] = htmlentities($_POST['description'], ENT_QUOTES, 'UTF-8');
			$this->insertElement();
		}
		$this->enum = "info";
		$collection = $this->selectAllElements();
		if ($collection->length() != 0) {
			$_SESSION['SO']->setBBDD('PANEL');
			$_SESSION['SO']->changeState (UNLOCK_STATE);
			$this->addToSitemap($_POST['domain']);
			SO::$ALERT = false;
			SO::$MESSAGE = '';
		} else 
			$this->onError("Los campos introducidos no son correctos, revisa que el dominio esté disponible y que la cuenta de usuario de Facebook y de Linkedin no estén ya registradas.");
	}
	
	//FUNCIONES DE PLANTILLAS
	public function configTemplate () {
		$_SESSION['SO']->setBBDD('TEMPLATE');
		try {
			$obj = $_SESSION['SO']->getElement($this->enum);
			$obj->setN($_POST);
			$from = $this->enum;
			$where = 'id_user = '.$_SESSION['SO']->getUID();
			$result = $_SESSION['SO']->select ($from, $fields = "*", $where);
			if ($result->num_rows == 0)
				$id = $_SESSION['SO']->executeInstruction ('insertElement', $obj);
			else {
				$this->id = $_GET['id'];
				$obj->setId($this->id);
				$_SESSION['SO']->executeInstruction ('updateElement', $obj);
			}
			$this->onError('Plantilla configurada correctamente!');
		} catch (Exception $e) {
			$this->onError($e->getMessage());
		}
		
		$_SESSION['SO']->setBBDD('PANEL');
	}
	
	public function selectTemplate () {
		$_SESSION['SO']->setBBDD('TEMPLATE');
		$obj = $_SESSION['SO']->getElement($this->enum);
		return $_SESSION['SO']->executeInstruction ('selectAllElements', $obj);
	}
	
	
	//FUNCIONES DE CEREBRO
	/**
	 * Analiza la información sensible de formar parte de la BBDD de datos generales y si es necesario
	 * la incluye.
	 */
	private function learnData() {
		$_SESSION['SO']->setBBDD('DATA');
		switch ($this->enum) {
			case "education":
				if (isset($_POST['nameCenter']) && $_POST['nameCenter'] != '') {
					try {
						$from = "center";
						$fields = array("name");
						$values = array($_POST['nameCenter']);
						$_SESSION['SO']->insert ($from, $fields, $values);
					} catch (Exception $e) {
						
					}
				}
				if (isset($_POST['specialty']) && $_POST['specialty'] != '') {
					try {
						$from = "specialty";
						$fields = array("name");
						$values = array($_POST['specialty']);
						$_SESSION['SO']->insert ($from, $fields, $values);
					} catch (Exception $e) {
					
					}
				}
				if (isset($_POST['titulation']) && $_POST['titulation'] != '') {
					try {
						$from = "titulation";
						$fields = array("name");
						$values = array($_POST['titulation']);
						$_SESSION['SO']->insert ($from, $fields, $values);
					} catch (Exception $e) {
							
					}
				}
			break;
			case "experience":
				if (isset($_POST['company']) && $_POST['company'] != '') {
					try {
						$from = "company";
						$fields = array("name");
						$values = array($_POST['company']);
						$_SESSION['SO']->insert ($from, $fields, $values);
					} catch (Exception $e) {
						
					}
				}
				if (isset($_POST['position']) && $_POST['position'] != '') {
					try {
						$from = "position";
						$fields = array("name");
						$values = array($_POST['position']);
						$_SESSION['SO']->insert ($from, $fields, $values);
					} catch (Exception $e) {
						
					}
				}
			break;
			case "language":
				if (isset($_POST['name']) && $_POST['name'] != '') {
					try {
						$from = "language";
						$fields = array("name");
						$values = array($_POST['name']);
						$_SESSION['SO']->insert ($from, $fields, $values);
					} catch (Exception $e) {
						
					}
				}
			break;
			case "skill":
				if (isset($_POST['name']) && $_POST['name'] != '') {
					try {
						$from = "skill";
						$fields = array("name");
						$values = array($_POST['name']);
						$_SESSION['SO']->insert ($from, $fields, $values);
					} catch(Exception $e) {
						
					}
				}
			break;
			case "mtlart":
				if (isset($_POST['category']) && $_POST['category'] != '') {
					try {
						$from = "art";
						$fields = array("name");
						$values = array($_POST['category']);
						$_SESSION['SO']->insert ($from, $fields, $values);
					} catch(Exception $e) {
						
					}
				}
			break;
			case "mtlculture":
				if (isset($_POST['category']) && $_POST['category'] != '') {
					try {
						$from = "culture";
						$fields = array("name");
						$values = array($_POST['category']);
						$_SESSION['SO']->insert ($from, $fields, $values);
					} catch(Exception $e) {
						
					}
				}
				if (isset($_POST['genre']) && $_POST['genre'] != '') {
					try {
						$from = "genre";
						$fields = array("name");
						$values = array($_POST['genre']);
						$_SESSION['SO']->insert ($from, $fields, $values);
					} catch(Exception $e) {
						
					}
				}
			break;
		}
	} 
	
	//FUNCIONES DE LA PILA
	
	/**
	 * Guarda en la PILA los datos que hayan sido introducidos hasta el
	 * momento.
	 */
	public function save () {
		$_SESSION['SO']->push($_POST);
	}
	
	/**
	 * Carga de la PILA los datos guardados de un elemento.
	 */
	public function load () {
		return $_SESSION['SO']->pop($_POST);
	}
	
	//FUNCIONES DE LA RAM
	
	/**
	 * Actualiza el valor de la versión en RAM.
	 */
	private function version() {
		if (isset($_POST['v'])) {
			$version = $_POST['v'];
			$_SESSION['SO']->eraseRAM ('version');
			$_SESSION['SO']->saveRAM ($version, 'version');
			$_SESSION['SO']->resetCache ();
		}
	}
	
	public function getVersion () {
		return $_SESSION['SO']->loadRAM ('version');
	}
	
	//CONTROL DE VERSIONES
	
	/**
	 * Chequea si la versión ya ha sido generada.
	 */
	private function checkVersion () {
		$this->setEnum('settings');
		$collection = $this->selectAllElements();
		$settings_array = $collection->getArray();
		foreach ($settings_array as $k => $v) {
			$settings = $v;
		}
		$version = $settings->get('v'.$_POST['v']);
		if (isset($version)) {
			if ($settings->get('v'.$_POST['v']) == 1)
				return false;
			else
				return true;
		} else 
			return false;
	}
	
	/**
	 * Copia las relaciones
	 */
	private function copyRelations ($enum, $v1, $v2) {
		$relations = array("language", "skill", "travel");
		$enums = $_SESSION['SO']->getEnums ();
		for ($i = 0; $i < count($relations); $i++) {
			$from = $enum.$relations[$i];
			if (in_array($from, $enums)) {
				for ($j = 0; $j < count($v1); $j++) {
					$where = 'id_'.$enum.' = '.$v1[$j];
					$result = $_SESSION['SO']->select($from, '*', $where);
					for ($h = 0; $h < $result->num_rows; $h++) {
						$result->data_seek($h);
						$row = $result->fetch_assoc();
						$fields = array('id_'.$enum, 'id_'.$relations[$i]);
						$values = array($v2[$j], $row['id_'.$relations[$i]]);
						$_SESSION['SO']->insert ($from, $fields, $values);
						unset($fields);
						unset($values);
					}
				}
			}
		}
	}
	
	/**
	 * Copia de elementos.
	 */
	private function copyElement ($enum) {
		$this->setEnum($enum);
		$collection = $this->selectAllElements();
		$items_array = $collection->getArray();
		$v1 = array();
		$v2 = array();
		echo $enum.'<br>';
		foreach ($items_array as $k => $v) {
			$array_values = $v->getValues();
			$fields = array();
			$values = array();
			foreach ($array_values as $f => $val) {
				$fields[] = $f;
				$values[] = $val;
			}
			$fields[] = "version";
			$values[] = $_POST['v'];
			if ($enum == 'info') {
				$pos = array_search('domain', $fields);
				$values[$pos] = $_POST['domain'];
			}
			$v1[] = $v->getId();
			$from = $enum;
			echo 'From: '.$enum.'<br>Fields: ';
			print_r($fields);
			echo '<br>Values: ';
			print_r($values);
			echo '<br>';
			/*$id = $_SESSION['SO']->insert ($from, $fields, $values);
			$v2[] = $id;*/
		}
		/*$this->copyRelations($enum, $v1, $v2);*/
	}
	
	/**
	 * Crea tablas necesarias en la nueva versión
	 */
	private function tablesNewVersion () {
		$this->setEnum('info');
		$collection = $this->selectAllElements();
		$info_array = $collection->getArray();
		foreach ($info_array as $k => $v) {
			$info = $v;
		}
		$version = $_POST['v'];
		$id_user = $_SESSION['SO']->getUID();
		$fields = array('id_user', 'name', 'surname', 'birthday', 'domain', 'country', 'city', 'version');
		$values = array($id_user, $info->get('name'), $info->get('surname'), $info->get('birthday'), $_POST['domain'], $info->get('country'), $info->get('city'), $version);
		$_SESSION['SO']->insert ('info', $fields, $values);
		$fields = array('id_user', 'version');
		$values = array($id_user, $version);
		$_SESSION['SO']->insert ('upgrade', $fields, $values);
		$fields = array('v'.$_POST['v']);
		$values = array(1);
		$where = 'id_user = '.$id_user;
		$_SESSION['SO']->update ('settings', $fields, $values, $where);
	}
	
	/**
	 * Genera una nueva versión.
	 */
	private function generateVersion () {
		$_SESSION['SO']->setBBDD('PANEL');
		if($this->checkVersion()) {
			if (!$this->domainExist($_POST['domain'])) {
				/*$elements = array("activity", "article", "blog", "education", "experience", "forum", "info", "language", "mtlart", "mtlculture", "mtlgeek", "mtlsport", "proyect", "skill", "travel", "upgrade");
				for ($i = 0; $i < count($elements); $i++)
					$this->copyElement($elements[$i]);*/
				$this->tablesNewVersion();
				$this->version();
			} else
				$this->onError('El dominio seleccionado ya existe.');
		} else
			$this->onError('La versión seleccionada ya está generada o no es correcta.');
	}
	
	//FUNCIONES DE LOCALIZACIÓN
	
	public function setParamsLocation ($direction) {
		return $_SESSION['SO']->setParamsLocation ($direction);
	}
	
	public function getParamLocation ($param) {
		return $_SESSION['SO']->getParamLocation ($param);
	}
	
	//FUNCIONES APIS
	
	public function getUrlFbk ($api) {
		return $_SESSION['SO']->getUrlFbk($api);
	}
	
	public function getFbkId () {
		return $_SESSION['SO']->getFbkId ();
	}
	
	private function getInfoFbk () {
		$this->facebook = $_SESSION['SO']->getInfoFbk();
	}
	
	public function insertFbkId ($id) {
		$user = $_SESSION['SO']->getUID();
		$fields = array("facebook");
		$values = array($id);
		$where = 'id_user = '.$user;
		$_SESSION['SO']->update('info', $fields, $values, $where);
	}
	
	public function getItemFbk ($item) {
		return $_SESSION['SO']->getItemFbk($item);
	}
	
	public function getFriends () {
		return $_SESSION['SO']->getFriends();
	}
	
	public function getFacebook () {
		return $this->facebook;
	}
	
	public function setParams () {
		$_SESSION['SO']->setParams($params);
	}
	
	private function extractFbkEducation ($content) {
		$education = array();
		foreach ($content as $item) {
			$ok = true;
			if (isset($item['school']))
				$education['nameCenter'] = $item['school']['name'];
			else
				$ok = false;
			if ($ok && isset($item['concentration'])) {
				$education['titulation'] = $item['concentration'][0]['name'];
			} else {
				if ($item['type'] == "High School")
					$education['titulation'] = "Educación Secundaria";
				else
					$education['titulation'] = "Titulación superior no especificada.";
			}
			if ($ok) {
				$obj = $_SESSION['SO']->getElement('education');
				$obj->setN($education);
				$id = $_SESSION['SO']->executeInstruction ('insertElement', $obj);
			}
		}
	}
	
	private function extractFbkExperience ($content) {
		$experience = array();
		foreach ($content as $item) {
			$ok = true;
			if (isset($item['employer']))
				$experience['company'] = $item['employer']['name'];
			else 
				$ok = false;
			if ($ok && isset($item['position']))
				$experience['position'] = $item['position']['name'];
			else
				$ok = false;
			if ($ok && isset($item['start_date']))
				$experience['start_date'] = $item['start_date'];
			if ($ok && isset($item['end_date']))
				$experience['end_date'] = $item['end_date'];
			if ($ok) {
				$obj = $_SESSION['SO']->getElement('experience');
				$obj->setN($experience);
				$id = $_SESSION['SO']->executeInstruction ('insertElement', $obj);
			}
		}
	}
	
	private function extractFbkLanguage ($content) {
		$language = array();
		foreach ($content as $item) {
			$ok = true;
			if (isset($item['name']))
				$language['name'] = $item['name'];
			else 
				$ok = false;
			if ($ok) {
				$obj = $_SESSION['SO']->getElement('language');
				$obj->setN($language);
				$id = $_SESSION['SO']->executeInstruction ('insertElement', $obj);
			}
		}
	}
	
	public function extractContentFbk ($content) {
		$_SESSION['SO']->setBBDD('PANEL');
		//Education
		if (isset($content['education']))
			$this->extractFbkEducation($content['education']);
		//Experience
		if (isset($content['work']))
			$this->extractFbkExperience($content['work']);
		//Language
		if (isset($content['languages']))
			$this->extractFbkLanguage($content['languages']);
	}
	
	//FUNCIONES PROGRAMA
	
	public function getStateUser () {
		$_SESSION['SO']->setBBDD('PANEL');
		return $_SESSION['SO']->getStateUser ();
	}
	
	public function domainExist($domain) {
		$_SESSION['SO']->setBBDD('PANEL');
		return $_SESSION['SO']->domainExist($domain);
	}
	
	public function onError ($message) {
		SO::$ALERT = true;
		SO::$MESSAGE = $message;
	}
	
	public function getDateElement ($date) {
		$zero = '0000-00-00';
		$months = array("", "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
		if ($date == $zero || $date == '')
			$date = '&nbsp';
		else {
			$aux = date_create($date);
			$month = $months[date_format($aux, 'n')];
			$year = date_format($aux, 'Y');
			$date =  $month .' '.$year;
		}
		
		return $date;
	}
	
	public function getField ($MEMO, $field) {
		if (isset($MEMO[$field]))
			return $MEMO[$field];
		else 
			return '';
	}
}