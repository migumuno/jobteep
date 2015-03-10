<?php
include_once 'Controllers/Controller.interface.php';

class ProfileController implements Controller {
	private $enum;
	private $UID;
	private $user;
	private $version;
	
	public function setUID ($UID) {
		$this->UID = $UID;
	}
	
	public function setUser ($user) {
		$this->user = $user;
	}
	
	public function setVersion ($version) {
		$this->version = $version;
	}
	
	public function getUserInfo () {
		$_SESSION['SO']->setBBDD('PANEL');
		$domain = $_GET['domain'];
		//Información del usuario
		$where = 'domain = "'.$domain.'"';
		$result = $_SESSION['SO']->select('info', '*', $where);
		$row = $result->fetch_assoc();
		//Nombre de usuario
		$where = 'id_user = '.$row['id_user'];
		$result2 = $_SESSION['SO']->select('user', '*', $where);
		$user = $result2->fetch_assoc();
		//Plantilla
		$where = 'id_user = '.$row['id_user'];
		$result3 = $_SESSION['SO']->select('settings', '*', $where);
		$settings = $result3->fetch_assoc();
		
		$row['user'] = $user['user'];
		$row['dir'] = $user['dir'];
		$row['template'] = strtolower($settings['template']);
		return $row;
	}
	
	public function getInfo ($user) {
		$where = 'id_user = '.$user;
		$result = $_SESSION['SO']->select('info', '*', $where);
		$row = $result->fetch_assoc();
		//Nombre de usuario
		$where = 'id_user = '.$row['id_user'];
		$result2 = $_SESSION['SO']->select('user', '*', $where);
		$user = $result2->fetch_assoc();
		//Plantilla
		$where = 'id_user = '.$row['id_user'];
		$result3 = $_SESSION['SO']->select('settings', '*', $where);
		$settings = $result3->fetch_assoc();
		
		$row['user'] = $user['user'];
		$row['dir'] = $user['dir'];
		$row['template'] = strtolower($settings['template']);
		return $row;
	}
	
	public function getSettings () {
		$_SESSION['SO']->setBBDD('PANEL');
		$where = 'id_user = '.$this->UID;
		$result = $_SESSION['SO']->select('settings', '*', $where);
		$row = $result->fetch_assoc();
		return $row;
	}
	
	public function getUpgrade () {
		$_SESSION['SO']->setBBDD('PANEL');
		$where = 'id_user = '.$this->UID;
		$result = $_SESSION['SO']->select('upgrade', '*', $where);
		$row = $result->fetch_assoc();
		return $row;
	}
	
	public function getTemplateInfo ($user, $template) {
		$_SESSION['SO']->setBBDD('TEMPLATE');
		$where = 'id_user = '.$user;
		$result = $_SESSION['SO']->select($template, '*', $where);
		$template = $result->fetch_assoc();
		return $template;
	}
	
	public function getProfileInfo ($id_user) {
		$where = 'id_user = '.$id_user;
		$result = $_SESSION['SO']->select('profile', '*', $where);
		$row = $result->fetch_assoc();
		return $row;
	}
	
	public function setEnum($enum) {
		$this->enum = $enum;
	}
	
	public function selectAllElements ($user, $order = null, $condition = null) {
		$_SESSION['SO']->setBBDD('PANEL');
		$where = 'id_user = '.$user.' AND version = '.$this->version;
		if (isset($condition))
			$where = $where.' AND '.$condition;
		return $result = $_SESSION['SO']->select($this->enum, '*', $where, null, null, $order);
	}
	
	public function selectImages ($proyect) {
		$_SESSION['SO']->setBBDD('PANEL');
		$where = 'id_user = '.$user.' AND id_proyect = '.$proyect;
		return $result = $_SESSION['SO']->select($this->enum, '*', $where, null, null, null);
	}
	
	public function selectAllRelations ($relation, $element) {
		$_SESSION['SO']->setBBDD('PANEL');
		$from = $this->enum.$relation.' AS r JOIN '.$relation.' AS l ON r.id_'.$relation.' = l.id_'.$relation;
		switch ($relation) {
			case "language":
				$fields = array("l.id_".$relation, "l.name", "l.level", "l.certificate");
				break;
			case "skill":
				$fields = array("l.id_".$relation, "l.name", "l.level", "l.certificate");
				break;
			case "travel":
				$fields = array("l.id_".$relation, "l.title", "l.location", "l.story", "l.start_date", "l.end_date", "l.img");
				break;
		}
		$where = 'r.id_'.$this->enum.' = '.$element;
		$result = $_SESSION['SO']->select($from, $fields, $where);
		return $result;
	}
	
	public function selectAllProyects ($element) {
		$_SESSION['SO']->setBBDD('PANEL');
		$fields = array("id_proyect", "title", "description", "start_date", "end_date");
		$where = 'id_user = '.$this->UID.' AND self = 0 AND '.$this->enum.' = '.$element.' AND version = '.$this->version;
		return $result = $_SESSION['SO']->select('proyect', $fields, $where, null, null, 'start_date DESC, id_proyect DESC');
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
	
	public function getTime ($start, $end) {
		$time = 'No indicado';
		$annos = 0;
		$meses = 0;
		if (isset($start) && $start != '' && $start != '0000-00-00'){
			$datetime1 = new DateTime($start);
			if (isset($end) && $end != '' && $end != '0000-00-00') {
				$datetime2 = new DateTime($end);
			} else {
				$datetime2 = new DateTime();
			}
			$meses = $datetime2->format('m') - $datetime1->format('m');
			$annos = $datetime2->format('Y') - $datetime1->format('Y');
			if ($meses < 1) {
				$annos--;
				$meses = 12 + $meses;
			}
			if ($meses == 12) {
				$annos++;
				$meses = 0;
			}
			$interval = $datetime1->diff($datetime2);
			if ($annos < 1)
				if (($meses > 1) || ($meses == 0))
					$time = $meses.' meses';
				else 
					$time = $meses.' mes';
			else
				if (($annos > 1) && ($meses > 1))
					$time = $annos.' años y '.$meses.' meses';
				else if (($annos == 1) && ($meses > 1))
					$time = $annos.' año y '.$meses.' meses';
				else if (($annos == 1) && ($meses == 1))
					$time = $annos.' año y '.$meses.' mes';
				else if (($annos > 1) && ($meses == 1))
					$time = $annos.' años y '.$meses.' mes';
				else if (($annos > 1) && ($meses == 0))
					$time = $annos.' años';
				else if (($annos == 1) && ($meses == 0))
					$time = $annos.' año';
			/*$time = $interval->format('%y año/s').' y '.$interval->format('%m mes/es');*/
		}
		return $time;
	}
	
	private function timeTravel ($start, $end) {
		$time = 0;
		if (isset($start) && $start != '' && $start != '0000-00-00') {
			if (isset($end) && $end != '' && $end != '0000-00-00') {
				$datetime1 = new DateTime($start);
				$datetime2 = new DateTime($end);
				$meses = $datetime2->format('m') - $datetime1->format('m');
				$annos = $datetime2->format('y') - $datetime1->format('y');
				if ($meses < 1) {
					$annos--;
					$meses = 12 + $meses;
				}
				if ($meses == 12) {
					$annos++;
					$meses = 0;
				}
				if ($annos == 0) {
					if ($meses < 2)
						$time = 0;
					else if ($meses < 9)
						$time = 1;
					else if ($meses > 8)
						$time = 2;
				} else
					$time = 2;
			}
		}
		return $time;
	}
	
	public function printMarker ($dir, $title, $type, $start, $end) {
		$time = $this->timeTravel($start, $end);
		try {
			$resultado = file_get_contents(sprintf('https://maps.googleapis.com/maps/api/geocode/json?sensor=false&address=%s', urlencode($dir)));
			$resultado = json_decode($resultado, TRUE);
			
			$lat = $resultado['results'][0]['geometry']['location']['lat'];
			$lng = $resultado['results'][0]['geometry']['location']['lng'];
			$types = array(
				0 => array(
					0 => ""
				),
				1 => array(
					0 => "ocio_circle_micro.png",
					1 => "ocio_circle_small.png",
					2 => "ocio_circle.png"
				),
				2 => array(
					0 => "trabajo_circle_micro.png",
					1 => "trabajo_circle_small.png",
					2 => "trabajo_circle.png"
				),
				3 => array(
					0 => "formacion_circle_micro.png",
					1 => "formacion_circle_small.png",
					2 => "formacion_circle.png"
				),
				4 => array(
					0 => "work_marker.png"
				)	
			);
			$imagen = "formacion_circle_small.png";
			echo '
			var pos = new google.maps.LatLng('.$lat.', '.$lng.');
	    	var marker = new google.maps.Marker({
				position: pos,
				map: map,
				title:"'.$title.'",
				animation: google.maps.Animation.DROP
			});
			marker.setIcon("Data/Templates/Origin/img/'.$imagen.'");
	    	';
		} catch (Exception $e) {
			
		}
	}
	
	public function trabajos () {
		$trabajos = array();
		
		//Obtener trabajos
		$this->enum = "experience";
		$result = $this->selectAllElements($this->UID, "start_date DESC");
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			/*if (isset($row['start_date']) && $row['start_date'] != '' && $row['start_date'] != '0000-00-00') {*/
				$trabajos[$i] = array();
				$trabajos[$i]['id_experience'] = $row['id_experience'];
				$trabajos[$i]['start_date'] = $row['start_date'];
				$trabajos[$i]['end_date'] = $row['end_date'];
				$trabajos[$i]['position'] = $row['position'];
				$trabajos[$i]['company'] = $row['company'];
				$trabajos[$i]['description'] = $row['description'];
				$trabajos[$i]['type'] = $row['type'];
				
				//Obtener idiomas relacionados
				$idiomas = $this->selectAllRelations('language', $row['id_experience']);
				if ($idiomas->num_rows != 0) {
					$trabajos[$i]['language'] = array();
					for ($j = 0; $j < $idiomas->num_rows; $j++) {
						$idiomas->data_seek($j);
						$item = $idiomas->fetch_assoc();
						foreach ($item as $k => $v) {
							$trabajos[$i]['language'][$j][$k] = $v;
						}
					}
				}
				
				//Obtener aptitudes relacionadas
				$aptitudes = $this->selectAllRelations('skill', $row['id_experience']);
				if ($aptitudes->num_rows != 0) {
					$trabajos[$i]['skill'] = array();
					for ($j = 0; $j < $aptitudes->num_rows; $j++) {
						$aptitudes->data_seek($j);
						$item = $aptitudes->fetch_assoc();
						foreach ($item as $k => $v) {
							$trabajos[$i]['skill'][$j][$k] = $v;
						}
					}
				}
				
				//Obtener viajes relacionados
				$viajes = $this->selectAllRelations('travel', $row['id_experience']);
				if ($viajes->num_rows != 0) {
					$trabajos[$i]['travel'] = array();
					for ($j = 0; $j < $viajes->num_rows; $j++) {
						$viajes->data_seek($j);
						$item = $viajes->fetch_assoc();
						foreach ($item as $k => $v) {
							$trabajos[$i]['travel'][$j][$k] = $v;
						}
					}
				}
				
				//Obtener proyectos relacionados
				$proyectos = $this->selectAllProyects($row['id_experience']);
				if ($proyectos->num_rows != 0) {
					$trabajos[$i]['proyect'] = array();
					for ($j = 0; $j < $proyectos->num_rows; $j++) {
						$proyectos->data_seek($j);
						$item = $proyectos->fetch_assoc();
						foreach ($item as $k => $v) {
							$trabajos[$i]['proyect'][$j][$k] = $v;
						}
					}
				}
			/*}*/
		}
		
		return $trabajos;
	}
	
	public function formacion () {
		$formacion = array();
		
		//Obtener trabajos
		$this->enum = "education";
		$result = $this->selectAllElements($this->UID, "start_date DESC");
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			/*if (isset($row['start_date']) && $row['start_date'] != '' && $row['start_date'] != '0000-00-00') {*/
				$formacion[$i] = array();
				$formacion[$i]['id_education'] = $row['id_education'];
				$formacion[$i]['start_date'] = $row['start_date'];
				$formacion[$i]['end_date'] = $row['end_date'];
				$formacion[$i]['titulation'] = $row['titulation'];
				$formacion[$i]['nameCenter'] = $row['nameCenter'];
				$formacion[$i]['qualification'] = $row['qualification'];
				$formacion[$i]['description'] = $row['description'];
				$formacion[$i]['certificate'] = $row['certificate'];
				$formacion[$i]['end'] = $row['end'];
				
				//Obtener idiomas relacionados
				$idiomas = $this->selectAllRelations('language', $row['id_education']);
				if ($idiomas->num_rows != 0) {
					$formacion[$i]['language'] = array();
					for ($j = 0; $j < $idiomas->num_rows; $j++) {
						$idiomas->data_seek($j);
						$item = $idiomas->fetch_assoc();
						foreach ($item as $k => $v) {
							$formacion[$i]['language'][$j][$k] = $v;
						}
					}
				}
				
				//Obtener aptitudes relacionadas
				$aptitudes = $this->selectAllRelations('skill', $row['id_education']);
				if ($aptitudes->num_rows != 0) {
					$formacion[$i]['skill'] = array();
					for ($j = 0; $j < $aptitudes->num_rows; $j++) {
						$aptitudes->data_seek($j);
						$item = $aptitudes->fetch_assoc();
						foreach ($item as $k => $v) {
							$formacion[$i]['skill'][$j][$k] = $v;
						}
					}
				}
				
				//Obtener viajes relacionados
				$viajes = $this->selectAllRelations('travel', $row['id_education']);
				if ($viajes->num_rows != 0) {
					$formacion[$i]['travel'] = array();
					for ($j = 0; $j < $viajes->num_rows; $j++) {
						$viajes->data_seek($j);
						$item = $viajes->fetch_assoc();
						foreach ($item as $k => $v) {
							$formacion[$i]['travel'][$j][$k] = $v;
						}
					}
				}
				
				//Obtener proyectos relacionados
				$proyectos = $this->selectAllProyects($row['id_education']);
				if ($proyectos->num_rows != 0) {
					$formacion[$i]['proyect'] = array();
					for ($j = 0; $j < $proyectos->num_rows; $j++) {
						$proyectos->data_seek($j);
						$item = $proyectos->fetch_assoc();
						foreach ($item as $k => $v) {
							$formacion[$i]['proyect'][$j][$k] = $v;
						}
					}
				}
			/*}*/
		}
		
		return $formacion;
	}
	
	public function proyectos ($all = true, $id = 0) {
		$proyectos = array();
		$this->enum = 'proyect';
		if ($id != 0)
			$result = $this->selectAllElements($this->UID, null, 'id_proyect = '.$id);
		else {
			if ($all)
				$result = $this->selectAllElements($this->UID, 'start_date DESC, id_proyect DESC');
			else 
				$result = $this->selectAllElements($this->UID, '-start_date DESC, id_proyect DESC', 'self = 1');
		}
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			if (isset($row['start_date']) && $row['start_date'] != '' && $row['start_date'] != '0000-00-00') {
				$proyectos[$i]['start_date'] = $row['start_date'];
				$proyectos[$i]['end_date'] = $row['end_date'];
			}
			$proyectos[$i]['title'] = $row['title'];
			$proyectos[$i]['description'] = $row['description'];
			$proyectos[$i]['id'] = $row['id_proyect'];
			
			//Obtener idiomas relacionados
			$idiomas = $this->selectAllRelations('language', $row['id_proyect']);
			if ($idiomas->num_rows != 0) {
				$proyectos[$i]['language'] = array();
				for ($j = 0; $j < $idiomas->num_rows; $j++) {
					$idiomas->data_seek($j);
					$item = $idiomas->fetch_assoc();
					foreach ($item as $k => $v) {
						$proyectos[$i]['language'][$j][$k] = $v;
					}
				}
			}
			
			//Obtener aptitudes relacionadas
			$aptitudes = $this->selectAllRelations('skill', $row['id_proyect']);
			if ($aptitudes->num_rows != 0) {
				$proyectos[$i]['skill'] = array();
				for ($j = 0; $j < $aptitudes->num_rows; $j++) {
					$aptitudes->data_seek($j);
					$item = $aptitudes->fetch_assoc();
					foreach ($item as $k => $v) {
						$proyectos[$i]['skill'][$j][$k] = $v;
					}
				}
			}
			
			//Obtener viajes relacionados
			$viajes = $this->selectAllRelations('travel', $row['id_proyect']);
			if ($viajes->num_rows != 0) {
				$proyectos[$i]['travel'] = array();
				for ($j = 0; $j < $viajes->num_rows; $j++) {
					$viajes->data_seek($j);
					$item = $viajes->fetch_assoc();
					foreach ($item as $k => $v) {
						$proyectos[$i]['travel'][$j][$k] = $v;
					}
				}
			}
			
			//Obtener imagenes del proyecto
			$_SESSION['SO']->setBBDD('PANEL');
			$where = 'id_user = '.$this->UID.' AND id_proyect = '.$row['id_proyect'];
			$imagenes = $_SESSION['SO']->select('proyectimg', '*', $where);
			if ($imagenes->num_rows != 0) {
				$proyectos[$i]['images'] = array();
				for ($j = 0; $j < $imagenes->num_rows; $j++) {
					$imagenes->data_seek($j);
					$item = $imagenes->fetch_assoc();
					foreach ($item as $k => $v) {
						$proyectos[$i]['images'][$j][$k] = $v;
					}
				}
			}
		}
		
		return $proyectos;
	}
	
	private function getRelations ($item, $element, $id_item) {
		$_SESSION['SO']->setBBDD('PANEL');
		$from = $item.' I JOIN '.$element.$item.' EI ON (I.id_'.$item.' = EI.id_'.$item.') JOIN '.$element.' E ON (EI.id_'.$element.' = E.id_'.$element.')';
		switch ($element) {
			case "experience":
				$fields = array("E.position", "E.company", "E.start_date", "E.end_date", "E.description");
				break;
			case "education":
				$fields = array("E.nameCenter", "E.titulation", "E.qualification", "E.start_date", "E.end_date", "E.description");
				break;
			case "proyect":
				$fields = array("E.title", "E.start_date", "E.end_date", "E.description");
				break;
		}
		$where = 'I.id_'.$item.' = '.$id_item.' AND I.version = '.$this->version;
		$result = $_SESSION['SO']->select($from, $fields, $where);
		return $result;
	}
	
	public function idiomas() {
		$idiomas = array();
		$this->enum = "language";
		$result = $this->selectAllElements($this->UID);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			$idiomas[$i] = array();
			$idiomas[$i]['name'] = $row['name'];
			$idiomas[$i]['level'] = $row['level'];
			$idiomas[$i]['certificate'] = $row['certificate'];
			$idiomas[$i]['story'] = $row['story'];
			$idiomas[$i]['id'] = $row['id_language'];
			$idiomas[$i]['experience'] = array();
			$idiomas[$i]['education'] = array();
			$idiomas[$i]['proyect'] = array();
			
			//Obtener trabajos relacionados
			$trabajos = $this->getRelations('language', 'experience', $row['id_language']);
			for ($j = 0; $j < $trabajos->num_rows; $j++) {
				$trabajos->data_seek($j);
				$item = $trabajos->fetch_assoc();
				foreach ($item as $k => $v) {
					$idiomas[$i]['experience'][$j][$k] = $v;
				}
			}

			//Obtener formaciones relacionados
			$formaciones = $this->getRelations('language', 'education', $row['id_language']);
			for ($j = 0; $j < $formaciones->num_rows; $j++) {
				$formaciones->data_seek($j);
				$item = $formaciones->fetch_assoc();
				foreach ($item as $k => $v) {
					$idiomas[$i]['education'][$j][$k] = $v;
				}
			}

			//Obtener proyectos relacionados
			$proyectos = $this->getRelations('language', 'proyect', $row['id_language']);
			for ($j = 0; $j < $proyectos->num_rows; $j++) {
				$proyectos->data_seek($j);
				$item = $proyectos->fetch_assoc();
				foreach ($item as $k => $v) {
					$idiomas[$i]['proyect'][$j][$k] = $v;
				}
			}
		}
		
		return $idiomas;
	}
	
	public function aptitudes() {
		$aptitudes = array();
		$this->enum = "skill";
		$result = $this->selectAllElements($this->UID);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			$aptitudes[$i] = array();
			$aptitudes[$i]['name'] = $row['name'];
			$aptitudes[$i]['level'] = $row['level'];
			$aptitudes[$i]['certificate'] = $row['certificate'];
			$aptitudes[$i]['story'] = $row['story'];
			$aptitudes[$i]['id'] = $row['id_skill'];
			$aptitudes[$i]['experience'] = array();
			$aptitudes[$i]['education'] = array();
			$aptitudes[$i]['proyect'] = array();
				
			//Obtener trabajos relacionados
			$trabajos = $this->getRelations('skill', 'experience', $row['id_skill']);
			for ($j = 0; $j < $trabajos->num_rows; $j++) {
				$trabajos->data_seek($j);
				$item = $trabajos->fetch_assoc();
				foreach ($item as $k => $v) {
					$aptitudes[$i]['experience'][$j][$k] = $v;
				}
			}
	
			//Obtener formaciones relacionados
			$formaciones = $this->getRelations('skill', 'education', $row['id_skill']);
			for ($j = 0; $j < $formaciones->num_rows; $j++) {
				$formaciones->data_seek($j);
				$item = $formaciones->fetch_assoc();
				foreach ($item as $k => $v) {
					$aptitudes[$i]['education'][$j][$k] = $v;
				}
			}
	
			//Obtener proyectos relacionados
			$proyectos = $this->getRelations('skill', 'proyect', $row['id_skill']);
			for ($j = 0; $j < $proyectos->num_rows; $j++) {
				$proyectos->data_seek($j);
				$item = $proyectos->fetch_assoc();
				foreach ($item as $k => $v) {
					$aptitudes[$i]['proyect'][$j][$k] = $v;
				}
			}
		}
	
		return $aptitudes;
	}
	
	public function viajes() {
		$viajes = array();
		$this->enum = "travel";
		$result = $this->selectAllElements($this->UID);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			$viajes[$row['id_travel']] = array();
			$viajes[$row['id_travel']]['type'] = $row['type'];
			$viajes[$row['id_travel']]['title'] = $row['title'];
			$viajes[$row['id_travel']]['location'] = $row['location'];
			$viajes[$row['id_travel']]['story'] = $row['story'];
			$viajes[$row['id_travel']]['start_date'] = $row['start_date'];
			$viajes[$row['id_travel']]['end_date'] = $row['end_date'];
			$viajes[$row['id_travel']]['img'] = $row['img'];
			$viajes[$row['id_travel']]['experience'] = array();
			$viajes[$row['id_travel']]['education'] = array();
			$viajes[$row['id_travel']]['proyect'] = array();
			$viajes[$row['id_travel']]['language'] = array();
	
			//Obtener trabajos relacionados
			$trabajos = $this->getRelations('travel', 'experience', $row['id_travel']);
			for ($j = 0; $j < $trabajos->num_rows; $j++) {
				$trabajos->data_seek($j);
				$item = $trabajos->fetch_assoc();
				foreach ($item as $k => $v) {
					$viajes[$row['id_travel']]['experience'][$j][$k] = $v;
				}
			}
	
			//Obtener formaciones relacionados
			$formaciones = $this->getRelations('travel', 'education', $row['id_travel']);
			for ($j = 0; $j < $formaciones->num_rows; $j++) {
				$formaciones->data_seek($j);
				$item = $formaciones->fetch_assoc();
				foreach ($item as $k => $v) {
					$viajes[$row['id_travel']]['education'][$j][$k] = $v;
				}
			}
	
			//Obtener proyectos relacionados
			$proyectos = $this->getRelations('travel', 'proyect', $row['id_travel']);
			for ($j = 0; $j < $proyectos->num_rows; $j++) {
				$proyectos->data_seek($j);
				$item = $proyectos->fetch_assoc();
				foreach ($item as $k => $v) {
					$viajes[$row['id_travel']]['proyect'][$j][$k] = $v;
				}
			}
			
			//Obtener idiomas relacionados
			$idiomas = $this->selectAllRelations('language', $row['id_travel']);
			if ($idiomas->num_rows != 0) {
				for ($j = 0; $j < $idiomas->num_rows; $j++) {
					$idiomas->data_seek($j);
					$item = $idiomas->fetch_assoc();
					foreach ($item as $k => $v) {
						$viajes[$row['id_travel']]['language'][$j][$k] = $v;
					}
				}
			}
		}
	
		return $viajes;
	}
	
	public function cultura () {
		$cultura = array();
		$this->enum = "mtlculture";
		$result = $this->selectAllElements($this->UID);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			$cultura[$row['id_mtlculture']] = array();
			$cultura[$row['id_mtlculture']]['category'] = $row['category'];
			$cultura[$row['id_mtlculture']]['title'] = $row['title'];
			$cultura[$row['id_mtlculture']]['description'] = $row['description'];
			$cultura[$row['id_mtlculture']]['img'] = $row['img'];
		}
		
		return $cultura;
	}
	
	public function aficiones () {
		$aficiones = array();
		$this->enum = "mtlart";
		$result = $this->selectAllElements($this->UID);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			$aficiones[$row['id_mtlart']] = array();
			$aficiones[$row['id_mtlart']]['category'] = $row['category'];
			$aficiones[$row['id_mtlart']]['title'] = $row['title'];
			$aficiones[$row['id_mtlart']]['description'] = $row['description'];
			$aficiones[$row['id_mtlart']]['img'] = $row['img'];
		}
		
		return $aficiones;
	}
	
	public function deporte() {
		$deporte = array();
		$this->enum = "mtlsport";
		$result = $this->selectAllElements($this->UID);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			$deporte[$row['id_mtlsport']] = array();
			$deporte[$row['id_mtlsport']]['category'] = $row['category'];
			$deporte[$row['id_mtlsport']]['description'] = $row['description'];
			$deporte[$row['id_mtlsport']]['frequency'] = $row['frequency'];
		}
		
		return $deporte;
	}
	
	public function levelDeporte ($deporte) {
		$level = 0;
		$points = 0;
		if (count($deporte) > 0) {
			foreach ($deporte as $k => $v) {
				switch ($v['frequency']) {
					case 0:
						$points += 1.1;
						break;
					case 1:
						$points += 1;
						break;
					case 2:
						$points += 0.5;
						break;
					case 3:
						$points += 0.2;
						break;
					case 4:
						$points += 0.1;
						break;
					case 5:
						$points += 0.1;
						break;
				}
			}
			if ($points < 1)
				$level = 1;
			else if ($points < 2)
				$level = 2;
			else if ($points >= 2)
				$level = 3;
		}
		
		return $level;
	}
	
	private function compareDates ($date1, $date2, $date3 = null) {
		$date1 = strtotime($date1);
		$date2 = strtotime($date2);
		if (!isset($date3)) {
			if ($date1 > $date2)
				return 1;
			else
				return 2;
		} else {
			$date3 = strtotime($date3);
			if ($date1 > $date2) {
				if ($date1 > $date3)
					return 1;
				else 
					return 3;
			} else {
				if ($date2 > $date3)
					return 2;
				else 
					return 3;
			}
		}
	}
	
	public function timeline ($formacion, $trabajos, $proyectos) {
		$timeline = array();
		for ($i = 0; $i < count($formacion); $i++) {
			$timeline[] = array(
				"type" => "education",
				"content" => $formacion[$i]
			);
		}
		for ($i = 0; $i < count($trabajos); $i++) {
			$timeline[] = array(
				"type" => "work",
				"content" => $trabajos[$i]
			);
		}
		for ($i = 0; $i < count($proyectos); $i++) {
			$timeline[] = array(
				"type" => "proyect",
				"content" => $proyectos[$i]
			);
		}
		
		function ordenar ($a, $b) {
			if (strtotime($a['content']['start_date']) == strtotime($b['content']['start_date']))
				return 0;
			else
				return (strtotime($a['content']['start_date']) > strtotime($b['content']['start_date'])) ? -1 : 1;
		}
		
		usort($timeline, 'ordenar');
		
		return $timeline;
	}
	
	private function getLevelActivity ($total) {
		$level = 0;
		if ($total == 0)
			$level = 0;
		else if ($total <= 2)
			$level = 1;
		else if ($total <=4)
			$level = 2;
		else if ($total <= 6)
			$level = 3;
		else if ($total >= 7)
			$level = 4;
		
		return $level;
	}
	
	public function activityLevels () {
		$this->enum = 'activity';
		$activities = array(
			"evento" => 0,
			"voluntariado" => 0,
			"hablar" => 0,
			"emprender" => 0	
		);
		$fecha = date('Y-m-d',strtotime('-12 months', strtotime("now")));
		$result = $this->selectAllElements($this->UID, "start_date DESC", 'start_date > "'.$fecha.'"');
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			if (isset($row['start_date']) && $row['start_date'] != '' && $row['start_date'] != '0000-00-00') {
				switch ($row['category']) {
					case 0:
						$activities['evento']++;
						break;
					case 1:
						$activities['voluntariado']++;
						break;
					case 2:
						$activities['hablar']++;
						break;
					case 3:
						$activities['emprender']++;
						break;
				}
			}
		}
		if ($activities['evento'] == 0) {
			$result = $this->selectAllElements($this->UID, "start_date DESC", 'start_date <= "'.$fecha.'" AND category = 0');
			if ($result->num_rows > 0)
				$activities['evento']++;
		}
		if ($activities['voluntariado'] == 0) {
			$result = $this->selectAllElements($this->UID, "start_date DESC", 'start_date <= "'.$fecha.'" AND category = 1');
			if ($result->num_rows > 0)
				$activities['voluntariado']++;
		}
		if ($activities['hablar'] == 0) {
			$result = $this->selectAllElements($this->UID, "start_date DESC", 'start_date <= "'.$fecha.'" AND category = 2');
			if ($result->num_rows > 0)
				$activities['hablar']++;
		}
		if ($activities['emprender'] == 0) {
			$result = $this->selectAllElements($this->UID, "start_date DESC", 'start_date <= "'.$fecha.'" AND category = 3');
			if ($result->num_rows > 0)
				$activities['emprender']++;
		}
		$activities['evento'] = $this->getLevelActivity($activities['evento']);
		$activities['voluntariado'] = $this->getLevelActivity($activities['voluntariado']);
		$activities['hablar'] = $this->getLevelActivity($activities['hablar']);
		$activities['emprender'] = $this->getLevelActivity($activities['emprender']);
		
		return $activities;
	}
	
	public function orderImages ($num) {
		$end = false;
		$aux = array();
		while (!$end) {
			switch ($num) {
				case 1:
					$orden = array(12);
					$aux = array_merge($aux, $orden);
					$end = true;
					break;
				case 2:
					$orden = array(6,6);
					$aux = array_merge($aux, $orden);
					$end = true;
					break;
				case 3:
					$orden = array(12,6,6);
					$aux = array_merge($aux, $orden);
					$end = true;
					break;
				case 4:
					$orden = array(12,4,4,4);
					$aux = array_merge($aux, $orden);
					$end = true;
					break;
				case 5:
					$orden = array(12,4,4,4,12);
					$aux = array_merge($aux, $orden);
					$end = true;
					break;
				case 6:
					$orden = array(12,6,6,4,4,4);
					$aux = array_merge($aux, $orden);
					$end = true;
					break;
				default:
					$orden = array(12,6,6,4,4,4);
					$aux = array_merge($aux, $orden);
					$num = $num - 6;
			}
		}
		
		return $aux;
	}
	
	public function saveProyects ($proyectos) {
		$p = array();
		foreach ($proyectos as $k => $v) {
			$p[$v['id']] = $v;
		}
		
		$_SESSION['proyectos'] = $p;
	}
	
	
	
	
	
	
	
	
	private function extractWork () {
		$works = array();
		$this->enum = "experience";
		$result = $this->selectAllElements($this->UID, "start_date ASC");
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			if (isset($row['start_date']) && $row['start_date'] != '' && $row['start_date'] != '0000-00-00'){
				$datetime1 = new DateTime($row['start_date']);
				$start = $datetime1->format('Y,n,j');
				if (isset($row['end_date']) && $row['end_date'] != '' && $row['end_date'] != '0000-00-00') {
					$datetime2 = new DateTime($row['end_date']);
					$end = $datetime2->format('Y,n,j');
				} else {
					$datetime2 = new DateTime('now');
					$end = $datetime2->format('Y,n,j');
				}
				$interval = $datetime1->diff($datetime2);
				$works[] = array(
					"startDate" => $start,
					"endDate" => $end,
					"headline" => "Trabajo",
					"text" => '<p><b>'.$row['position'].' en '.$row['company'].' durante '.$interval->y.' años y '.$interval->m.' meses.</b>'.html_entity_decode($row['description']).'</p>',
					"asset" => array(
						"media" => "",
						"credit" => "",
						"caption" => ""
					)
				);
			}
		}
		return $works;
	}
	
	private function extractEducation () {
		$education = array();
		$this->enum = "education";
		$result = $this->selectAllElements($this->UID, "start_date ASC");
		$qualifications = array("", "Educación Secundaria", "Curso", "FP Media", "Máster", "Doctorado", "FP Superior", "Carrera");
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			if (isset($row['start_date']) && $row['start_date'] != '' && $row['start_date'] != '0000-00-00'){
				$datetime1 = new DateTime($row['start_date']);
				$start = $datetime1->format('Y,n,j');
				if (isset($row['end_date']) && $row['end_date'] != '' && $row['end_date'] != '0000-00-00') {
					$datetime2 = new DateTime($row['end_date']);
					$end = $datetime2->format('Y,n,j');
				} else {
					$datetime2 = new DateTime('now');
					$end = $datetime2->format('Y,n,j');
				}
				$interval = $datetime1->diff($datetime2);
				$education[] = array(
					"startDate" => $start,
					"endDate" => $end,
					"headline" => "Formación",
					"text" => $qualifications[$row['qualification']].' de '.$row['titulation'].' en '.$row['nameCenter'],
					"asset" => array(
						"media" => "",
						"credit" => "",
						"caption" => ""
					)
				);
			}
		}
		return $education;
	}
	
	private function extractProyect () {
		$proyect = array();
		$this->enum = "proyect";
		$result = $this->selectAllElements($this->UID, "start_date ASC");
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			if (isset($row['start_date']) && $row['start_date'] != '' && $row['start_date'] != '0000-00-00'){
				$datetime1 = new DateTime($row['start_date']);
				$start = $datetime1->format('Y,n,j');
				if (isset($row['end_date']) && $row['end_date'] != '' && $row['end_date'] != '0000-00-00') {
					$datetime2 = new DateTime($row['end_date']);
					$end = $datetime2->format('Y,n,j');
				} else {
					$datetime2 = new DateTime('now');
					$end = $datetime2->format('Y,n,j');
				}
				$interval = $datetime1->diff($datetime2);
				$proyect[] = array(
						"startDate" => $start,
						"endDate" => $end,
						"headline" => "Proyecto",
						"text" => $row['title'],
						"asset" => array(
								"media" => "http://www.jobteep.com/Data/Users/miguelamv11@gmail.com/jobteep.png",
								"credit" => "",
								"caption" => ""
						)
				);
			}
		}
		return $proyect;
	}
	
	private function extractActivity () {
		$activity = array();
		$this->enum = "activity";
		$result = $this->selectAllElements($this->UID, "start_date ASC");
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			if (isset($row['start_date']) && $row['start_date'] != '' && $row['start_date'] != '0000-00-00'){
				$datetime1 = new DateTime($row['start_date']);
				$start = $datetime1->format('Y,n,j');
				$activity[] = array(
						"startDate" => $start,
						"headline" => "Actividad",
						"text" => $row['title'],
						"asset" => array(
								"media" => "",
								"credit" => "",
								"caption" => ""
						)
				);
			}
		}
		return $activity;
	}
	
	private function extractTravel () {
		$travel = array();
		$this->enum = "travel";
		$result = $this->selectAllElements($this->UID, "start_date ASC");
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			if (isset($row['start_date']) && $row['start_date'] != '' && $row['start_date'] != '0000-00-00'){
				$datetime1 = new DateTime($row['start_date']);
				$start = $datetime1->format('Y,n,j');
				if (isset($row['end_date']) && $row['end_date'] != '' && $row['end_date'] != '0000-00-00') {
					$datetime2 = new DateTime($row['end_date']);
					$end = $datetime2->format('Y,n,j');
				} else {
					$datetime2 = new DateTime('now');
					$end = $datetime2->format('Y,n,j');
				}
				$location = str_replace(" ", "+", $row['location']);
				$interval = $datetime1->diff($datetime2);
				$travel[] = array(
						"startDate" => $start,
						"endDate" => $end,
						"headline" => "Viaje",
						"text" => '<p>'.$row['title'].'</p><p>'.$row['location'].'</p>',
						"asset" => array(
								"media" => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d158858.1823707257!2d-0.10159865000000001!3d51.52864165!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47d8a00baf21de75%3A0x52963a5addd52a99!2sLondres%2C+Reino+Unido!5e0!3m2!1ses!2ses!4v1418738052591" width="600" height="450" frameborder="0" style="border:0"></iframe>',
								"credit" => "",
								"caption" => ""
						)
				);
			}
		}
		return $travel;
	}
	
	public function genTimelineJson () {
		$info = $this->getUserInfo();
		$works = $this->extractWork();
		$education = $this->extractEducation();
		$proyect = $this->extractProyect();
		$activity = $this->extractActivity();
		$travel = $this->extractTravel();
		$event = array_merge($works, $education, $proyect, $activity, $travel);
		if (count($event) > 0) {
			$json = array(
				"timeline" => array(
					"headline" => strtoupper($info['name']).' '.strtoupper($info['surname']),
					"type" => "default",
					"text" => "<p>".strtoupper($info['slogan'])."</p>".html_entity_decode($info['description']),
					"date" => $event
				)
			);
			$json = json_encode($json);
			/*$_SESSION['brain'] = $json;*/
			$dir = $_SESSION['SO']->getUserInfo ('dir');
			$fp = fopen('Data/Users/'.$dir.'/timeline.json', 'w');
			fwrite($fp, $json);
			fclose($fp);
			return true;
		} else
			return false;
	}
}