<?php
include_once 'Controllers/Controller.interface.php';

class BrainController implements Controller {
	private $sectors;
	public $name_sectors;
	private $user;
	private $version;
	private $domain;
	public $message;
	public $title;
	
	function BrainController() {
		$this->name_sectors = array();
		$this->domain = '';
		$this->title = '<h2 class = "text-center">Comandos</h2>';
		$this->message = $this->help();
	}
	
	public function executeAction () {
		$action = $_GET['action'];
		switch ($action) {
			case "command":
				$this->command();
				break;
		}
	}
	
	private function command () {
		$command = explode(" ", strtolower($_POST['command']));
		switch ($command[0]) {
			case 'hi':
				$this->message = 'Hola '.$this->getAdminName().'!';
				break;
			case "whatsapp":
				$this->message = 'Genial! Deseando trabajar. Gracias por preguntar :)';
				break;
			case "name":
				$this->message = 'Mi nombre es Brain, qué puedo hacer por ti?.';
				break;
			case "bye":
				$this->message = '';
				$this->title = '';
				$this->domain = '';
				header('Location: ?action=adminlogout');
				break;
			case "help":
				$this->title = '<h2 class = "text-center">Comandos</h2>';
				$this->message = $this->help();
				break;
			case "numusers":
				$num = $this->numUsers();
				$this->message = 'Hay '.$num.' usuarios registrados';
				break;
			case "domain":
				$this->setDomain($command[1]);
				break;
			case "sectors":
				$this->title = '<h2 class = "text-center">Sectores y puntuación</h2>';
				$this->message = $this->printSectors();
				break;
			case "generalculture":
				$this->title = '<h2 class = "text-center">Competencia: Cultura General</h2>';
				$this->message = $this->printGeneralCulture();
				break;
			case "creativity":
				$this->title = '<h2 class = "text-center">Competencia: Creatividad</h2>';
				$this->message = $this->printCreativity();
				break;
			case "marketing":
				$this->title = '<h2 class = "text-center">Competencia: Marketing y Ventas</h2>';
				$this->message = $this->printMarketing();
				break;
			case "tic":
				$this->title = '<h2 class = "text-center">Competencia: Manejo de las TIC</h2>';
				$this->message = $this->printTIC();
				break;
			case "capabilities":
				$this->title = '<h2 class = "text-center">Competencias</h2>';
				$this->message = $this->printCapabilities();
				break;
			case "ei":
				$this->title = '<h2 class = "text-center">Competencia: Inteligencia Emocional</h2>';
				$this->message = $this->emotionalIntelligence();
				break;
			case "relation":
				$this->message = $this->printRelation();
				break;
			default:
				$this->message = 'No te entiendo.';
		}
	}
	
	public function help () {
		$txt = '
		<ul>
			<li><b>hi</b>: Saludo.</li>
			<li><b>whatsapp</b>: ¿Qué tal?</li>
			<li><b>name</b>: Nombre sistema.</li>
			<li><b>bye</b>: Salir.</li>
			<li><b>help</b>: Muestra los comandos disponibles.</li>
			<li><b>numusers</b>: Número de usuarios registrados.</li>
			<li><b>domain</b>: Usuario seleccionado.</li>
			<li><b>sectors</b>: Sectores del usuario.</li>
			<li><b>generalCulture</b>: Capacidad Cultura General.</li>
			<li><b>creativity</b>: Capacidad Creatividad.</li>
			<li><b>marketing</b>: Capacidad Marketing y Ventas.</li>
			<li><b>tic</b>: Capacidad Tecnologías de la Información y Comunicación.</li>
			<li><b>capabilities</b>: Gráfico capacidades.</li>
			<li><b>ei</b>: Inteligencia emocional.</li>
			<li><b>relation</b>: Gráfico de relaciones</li>
		</ul>
		';
		
		return $txt;
	}
	
	public function getMessage () {
		$message = $this->message;
		$this->message = '';
		$this->title = '';
		return $message;
	}
	
	public function getAdminName () {
		return $_SESSION['SO']->getAdminName ();
	}
	
	public function userExist($user) {
		$_SESSION['SO']->setBBDD('PANEL');
		return $_SESSION['SO']->userExist($user);
	}
	
	private function getUser ($domain) {
		$where = 'domain = "'.$domain.'"';
		$_SESSION['SO']->setBBDD('PANEL');
		$result = $_SESSION['SO']->select('info', '*', $where);
		if ($result->num_rows != 0) {
			$row = $result->fetch_assoc();
			$this->user = $row['id_user'];
			$this->version = $row['version'];
			$this->domain = $domain;
			return true;
		} else 
			return false;
	}
	
	private function getCoefficientSectors ($item, $percent) {
		foreach ($item as $k => $v) {
			if ($item[$k] >= 10)
				$value = 10;
			else
				$value = $item[$k];
			if (array_key_exists($k, $this->sectors))
				$this->sectors[$k] = $this->sectors[$k] + round(($value * $percent),2);
			else
				$this->sectors[$k] = round($value * $percent,2);
		}
	}
	
	private function getDiffTime ($start, $end, $mode) {
		$datetime1 = new DateTime($start);
		$datetime2 = new DateTime($end);
		$interval = $datetime1->diff($datetime2);
		switch ($mode) {
			case "d":
				$v = $interval->d;
				break;
			case "m":
				$v = $interval->m;
				break;
			case "y":
				$v = $interval->y;
				break;
		}
		return $v;
	}
	
	private function educationSectors () {
		$education = array();
		$from = "education";
		$where = 'id_user = '.$this->user.' AND version = '.$this->version;
		$_SESSION['SO']->setBBDD('PANEL');
		$result = $_SESSION['SO']->select ($from, '*', $where);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$certificate = 0;
			$level = 0;
			$type = 0;
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			//CERTIFICADO
			if ($row['certificate'] != '' && isset($row['certificate']))
				$certificate = 10;
			//NIVEL
			switch ($row['qualification']) {
				case 2:
					$level = 2;
					break;
				case 3:
					$level = 3;
					break;
				case 4:
					$level = 4;
					break;
				case 5:
					$level = 4;
					break;
				case 6:
					$level = 5;
					break;
				case 7:
					$level = 10;
					break;
			}
			//TIPO
			if ($row['sector'] != 'none' && isset($row['sector'])) {
				if (array_key_exists($row['sector'], $this->name_sectors)) {
					if (!array_key_exists($row['sector'], $education)) {
						$education[$row['sector']] = ($level * 0.7) + (10 * 0.2) + ($certificate * 0.1);
					} else {
						$aux = ($level * 0.7) + (10 * 0.2) + ($certificate * 0.1);
						$education[$row['sector']] = $education[$row['sector']] + $aux;
					}
				}
			}
			if ($row['sector'] != $row['subsector']) {
				if ($row['subsector'] != 'none' && isset($row['subsector'])) {
					if (array_key_exists($row['subsector'], $this->name_sectors)) {
						if (!array_key_exists($row['subsector'], $education)) {
							$education[$row['subsector']] = ($level * 0.7) + (5 * 0.2) + ($certificate * 0.1);
						} else {
							$aux = ($level * 0.7) + (5 * 0.2) + ($certificate * 0.1);
							$education[$row['subsector']] = $education[$row['subsector']] + $aux;
						}
					}
				}
			}
		}
		$this->getCoefficientSectors($education, 0.3);
	}
	
	private function skillSectors () {
		$skill = array();
		$from = "skill";
		$where = 'id_user = '.$this->user.' AND version = '.$this->version;
		$_SESSION['SO']->setBBDD('PANEL');
		$result = $_SESSION['SO']->select ($from, '*', $where);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$certificate = 0;
			$level = 0;
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			//CERTIFICADO
			if ($row['certificate'] != '' && isset($row['certificate']))
				$certificate = 10;
			//NIVEL
			switch ($row['level']) {
				case 0:
					$level = 2;
					break;
				case 1:
					$level = 4;
					break;
				case 2:
					$level = 6;
					break;
				case 3:
					$level = 8;
					break;
				case 4:
					$level = 10;
					break;
			}
			if ($row['sector'] != 'none' && isset($row['sector'])) {
				if (array_key_exists($row['sector'], $this->name_sectors)) {
					if (!array_key_exists($row['sector'], $skill)) {
						$skill[$row['sector']] = (($level * 0.8) + ($certificate * 0.2)) * (1/4);
					} else {
						$aux = (($level * 0.8) + ($certificate * 0.2)) * (1/4);
						$skill[$row['sector']] = $skill[$row['sector']] + $aux;
					}
				}
			}
		}
		$this->getCoefficientSectors($skill, 0.25);
	}
	
	private function workSectors () {
		$work = array();
		$from = "experience";
		$where = 'id_user = '.$this->user.' AND version = '.$this->version;
		$_SESSION['SO']->setBBDD('PANEL');
		$result = $_SESSION['SO']->select ($from, '*', $where);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$time = 0;
			$type = 0;
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			//TIEMPO
			if (isset($row['start_date']) && $row['start_date'] != '' && $row['start_date'] != '0000-00-00'){
				if (isset($row['end_date']) && $row['end_date'] != '' && $row['end_date'] != '0000-00-00') {
					$years = $this->getDiffTime($row['start_date'], $row['end_date'], 'y');
					$months = $this->getDiffTime($row['start_date'], $row['end_date'], 'm') + ($years * 12);
				} else {
					$years = $this->getDiffTime($row['start_date'], 'now', 'y');
					$months = $this->getDiffTime($row['start_date'], 'now', 'm') + ($years * 12);
				}
				if ($months < 7) {
					$time = 2.5;
				} else if ($months < 13) {
					$time = 5;
				} else if ($months < 25) {
					$time = 7.5;
				} else if ($months >= 25) {
					$time = 10;
				}
			}
			//TIPO
			if ($row['sector'] != 'none' && isset($row['sector'])) {
				if (array_key_exists($row['sector'], $this->name_sectors)) {
					if (!array_key_exists($row['sector'], $work)) {
						$work[$row['sector']] = (($time * 0.8) + (10 * 0.2)) * (1/2);
					} else {
						$aux = (($time * 0.8) + (10 * 0.2)) * (1/2);
						$work[$row['sector']] = $work[$row['sector']] + $aux;
					}
				}
			}
			if ($row['sector'] != $row['subsector']) {
				if ($row['subsector'] != 'none' && isset($row['subsector'])) {
					if (array_key_exists($row['subsector'], $this->name_sectors)) {
						if (!array_key_exists($row['subsector'], $work)) {
							$work[$row['subsector']] = (($time * 0.8) + (5 * 0.2)) * (1/2);
						} else {
							$aux = (($time * 0.8) + (5 * 0.2)) * (1/2);
							$work[$row['subsector']] = $work[$row['subsector']] + $aux;
						}
					}
				}
			}
		}
		$this->getCoefficientSectors($work, 0.175);
	}
	
	private function proyectSectors () {
		$proyect = array();
		$from = "proyect";
		$where = 'id_user = '.$this->user.' AND version = '.$this->version;
		$_SESSION['SO']->setBBDD('PANEL');
		$result = $_SESSION['SO']->select ($from, '*', $where);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$time = 0;
			$type = 0;
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			//TIEMPO
			if (isset($row['start_date']) && $row['start_date'] != '' && $row['start_date'] != '0000-00-00'){
				if (isset($row['end_date']) && $row['end_date'] != '' && $row['end_date'] != '0000-00-00') {
					$months = $this->getDiffTime($row['start_date'], $row['end_date'], 'm');
				} else {
					$months = $this->getDiffTime($row['start_date'], 'now', 'm');
				}
				if ($months < 4)
					$time = 2.5;
				else if ($months < 7)
					$time = 5;
				else if (months < 13)
					$time = 7.5;
				else if (months >= 13)
					$time = 10;
			}
			//TIPO
			if ($row['sector'] != 'none' && isset($row['sector'])) {
				if (array_key_exists($row['sector'], $this->name_sectors)) {
					if (!array_key_exists($row['sector'], $proyect)) {
						$proyect[$row['sector']] = (($time * 0.8) + (10 * 0.2)) * (1/3);
					} else {
						$aux = (($time * 0.8) + (10 * 0.2)) * (1/3);
						$proyect[$row['sector']] = $proyect[$row['sector']] + $aux;
					}
				}
			}
			if ($row['sector'] != $row['subsector']) {
				if ($row['subsector'] != 'none' && isset($row['subsector'])) {
					if (array_key_exists($row['subsector'], $this->name_sectors)) {
						if (!array_key_exists($row['subsector'], $proyect)) {
							$proyect[$row['subsector']] = (($time * 0.8) + (5 * 0.2)) * (1/3);
						} else {
							$aux = (($time * 0.8) + (5 * 0.2)) * (1/3);
							$proyect[$row['subsector']] = $proyect[$row['subsector']] + $aux;
						}
					}
				}
			}
		}
		$this->getCoefficientSectors($proyect, 0.175);
	}
	
	private function activitySectors () {
		$activity = array();
		$from = "activity";
		$where = 'id_user = '.$this->user.' AND version = '.$this->version;
		$_SESSION['SO']->setBBDD('PANEL');
		$result = $_SESSION['SO']->select ($from, '*', $where);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			//TIPO
			if ($row['sector'] != 'none' && isset($row['sector'])) {
				if (array_key_exists($row['sector'], $this->name_sectors)) {
					if (!array_key_exists($row['sector'], $activity)) {
						$activity[$row['sector']] = 10 * (1/3);
					} else {
						$aux = 10 * (1/3);
						$activity[$row['sector']] = $activity[$row['sector']] + $aux;
					}
				}
			}
		}
		$this->getCoefficientSectors($activity, 0.05);
	}
	
	private function blogSectors () {
		$blog = array();
		$from = "blog";
		$where = 'id_user = '.$this->user.' AND version = '.$this->version;
		$_SESSION['SO']->setBBDD('PANEL');
		$result = $_SESSION['SO']->select ($from, '*', $where);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$url = 0;
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			//URL
			if ($row['url'] != '' && isset($row['url']))
				$url = 10;
			//TIPO
			if ($row['sector1'] != 'none' && isset($row['sector1'])) {
				if (array_key_exists($row['sector1'], $this->name_sectors)) {
					if (!array_key_exists($row['sector1'], $blog)) {
						$blog[$row['sector1']] = (10 * 0.8) + ($url * 0.2);
					} else {
						$aux = (10 * 0.8)+ ($url * 0.2);
						$blog[$row['sector1']] = $blog[$row['sector1']] + $aux;
					}
				}
			}
			if ($row['sector1'] != $row['sector2']) {
				if ($row['sector2'] != 'none' && isset($row['sector2'])) {
					if (array_key_exists($row['sector2'], $this->name_sectors)) {
						if (!array_key_exists($row['sector2'], $blog)) {
							$blog[$row['sector2']] = (9 * 0.8) + ($url * 0.2);
						} else {
							$aux = (9 * 0.8) + ($url * 0.2);
							$blog[$row['sector2']] = $blog[$row['sector2']] + $aux;
						}
					}
				}
			}
			if (($row['sector3'] != $row['sector1']) && ($row['sector3'] != $row['sector2'])) {
				if ($row['sector3'] != 'none' && isset($row['sector3'])) {
					if (array_key_exists($row['sector3'], $this->name_sectors)) {
						if (!array_key_exists($row['sector3'], $blog)) {
							$blog[$row['sector3']] = (8 * 0.8) + ($url * 0.2);
						} else {
							$aux = (8 * 0.8) + ($url * 0.2);
							$blog[$row['sector3']] = $blog[$row['sector3']] + $aux;
						}
					}
				}
			}
		}
		foreach ($blog as $k => $v) {
			if ($blog[$k] >= 10)
				$blog[$k] = 10;
		}
		return $blog;
	}
	
	private function articleSectors () {
		$article = array();
		$from = "article";
		$where = 'id_user = '.$this->user.' AND version = '.$this->version;
		$_SESSION['SO']->setBBDD('PANEL');
		$result = $_SESSION['SO']->select ($from, '*', $where);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$url = 0;
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			//URL
			if ($row['url'] != '' && isset($row['url']))
				$url = 10;
			//TIPO
			if ($row['sector'] != 'none' && isset($row['sector'])) {
				if (array_key_exists($row['sector'], $this->name_sectors)) {
					if (!array_key_exists($row['sector'], $blog)) {
						$blog[$row['sector']] = (8 + ($url * 0.2)) * (1/5);
					} else {
						$aux = (8 + ($url * 0.2)) * (1/5);
						$blog[$row['sector']] = $blog[$row['sector']] + $aux;
					}
				}
			}
		}
		foreach ($article as $k => $v) {
			if ($article[$k] >= 10)
				$article[$k] = 10;
		}
		return $article;
	}
	
	private function forumSectors () {
		$forum = array();
		$from = "blog";
		$where = 'id_user = '.$this->user.' AND version = '.$this->version;
		$_SESSION['SO']->setBBDD('PANEL');
		$result = $_SESSION['SO']->select ($from, '*', $where);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$url = 0;
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			//TIPO
			if ($row['sector1'] != 'none' && isset($row['sector1'])) {
				if (array_key_exists($row['sector1'], $this->name_sectors)) {
					if (!array_key_exists($row['sector1'], $forum)) {
						$forum[$row['sector1']] = ($row['themes'] * 0.5 * 0.8) + (10 * 0.2);
					} else {
						$aux = ($row['themes'] * 0.5 * 0.8) + (10 * 0.2);
						$forum[$row['sector1']] = $forum[$row['sector1']] + $aux;
					}
				}
			}
			if ($row['sector1'] != $row['sector2']) {
				if ($row['sector2'] != 'none' && isset($row['sector2'])) {
					if (array_key_exists($row['sector2'], $this->name_sectors)) {
						if (!array_key_exists($row['sector2'], $forum)) {
							$forum[$row['sector2']] = ($row['themes'] * 0.5 * 0.8) + (5 * 0.2);
						} else {
							$aux = ($row['themes'] * 0.5 * 0.8) + (5 * 0.2);
							$forum[$row['sector2']] = $forum[$row['sector2']] + $aux;
						}
					}
				}
			}
		}
		foreach ($forum as $k => $v) {
			if ($forum[$k] >= 10)
				$forum[$k] = 10;
		}
		return $forum;
	}
	
	private function publications () {
		$publications = array();
		$blogs = $this->blogSectors();
		foreach ($blogs as $k => $v) {
			if (array_key_exists($k, $publications))
				$publications[$k] = $publications[$k] + $v;
			else
				$publications[$k] = $v;
		}
		$articles = $this->articleSectors();
		foreach ($articles as $k => $v) {
			if (array_key_exists($k, $publications))
				$publications[$k] = $publications[$k] + $v;
			else
				$publications[$k] = $v;
		}
		$forums = $this->forumSectors();
		foreach ($forums as $k => $v) {
			if (array_key_exists($k, $publications))
				$publications[$k] = $publications[$k] + $v;
			else
				$publications[$k] = $v;
		}
		$this->getCoefficientSectors($publications, 0.05);
	}
	
	private function culturalLevel () {
		$from = "mtlculture";
		$where = 'id_user = '.$this->user.' AND version = '.$this->version;
		$_SESSION['SO']->setBBDD('PANEL');
		$result = $_SESSION['SO']->select ($from, '*', $where);
		$cinema = array();
		$theater = array();
		$reading = array();
		for ($i = 0; $i < $result->num_rows; $i++) {
			$review = 0;
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			//REVIEW
			if ($row['description'] != '' && isset($row['description']))
				$review = 10;
			if ($row['category'] == 'Cine') {
				if (!array_key_exists($row['genre'], $cinema))
					$cinema['genre'] = (($review * 0.2) + 8) * (1/4);
				else 
					$cinema['genre'] = $cinema['genre'] + ((($review * 0.2) + 8) * (1/4));
			} else if ($row['category'] == 'Teatro') {
				$theater[] = (($review * 0.2) + 8) * 0.1;
			} else if ($row['category'] == 'Lectura') {
				if (!array_key_exists($row['genre'], $reading))
					$reading['genre'] = (($review * 0.2) + 8) * (1/4);
				else
					$reading['genre'] = $reading['genre'] + ((($review * 0.2) + 8) * (1/4));
			}
		}
		$total_cinema = 0;
		foreach ($cinema as $k => $v) {
			if ($v >= 10)
				$v = 10;
			$total_cinema = $total_cinema + ($v * 0.2);
		}
		if ($total_cinema >= 10)
			$total_cinema = 10;
		$total_theater = 0;
		foreach ($theater as $k => $v) {
			$total_theater = $total_theater + $v;
		}
		if ($total_theater >= 10)
			$total_theater = 10;
		$total_reading = 0;
		foreach ($reading as $k => $v) {
			if ($v >= 10)
				$v = 10;
			$total_reading = $total_reading + ($v * 0.2);
		}
		if ($total_reading >= 10)
			$total_reading = 10;
		$culturalLevel = ($total_cinema * (1/3)) + ($total_theater * (1/3)) + ($total_reading * (1/3));
		
		return $culturalLevel;
	}
	
	private function artisticLevel () {
		$from = "mtlart";
		$art = array();
		$where = 'id_user = '.$this->user.' AND version = '.$this->version;
		$_SESSION['SO']->setBBDD('PANEL');
		$result = $_SESSION['SO']->select ($from, '*', $where);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			if (!array_key_exists($row['category'], $art))
				$art['category'] = 10 * (1/3);
			else
				$art['category'] = $art['category'] + (10 * (1/3));
		}
		$artisticLevel = 0;
		foreach ($art as $k => $v) {
			if ($v >= 10)
				$v = 10;
			$artisticLevel = $artisticLevel + ($v * (1/4));
		}
		if ($artisticLevel >= 10)
			$artisticLevel = 10;
		
		return $artisticLevel;
	}
	
	private function educationLevel () {
		$from = "education";
		$education = 0;
		$where = 'id_user = '.$this->user.' AND version = '.$this->version;
		$_SESSION['SO']->setBBDD('PANEL');
		$result = $_SESSION['SO']->select ($from, '*', $where);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			$level = 0;
			//NIVEL
			switch ($row['qualification']) {
				case 2:
					$level = 0.5;
					break;
				case 3:
					$level = 0.5;
					break;
				case 4:
					$level = 1;
					break;
				case 5:
					$level = 1.5;
					break;
				case 6:
					$level = 2.5;
					break;
				case 7:
					$level = 6;
					break;
			}
			$education = $education + $level;
		}
		if ($education >= 10)
			$education = 10;
		
		return $education;
	}
	
	private function locationLevel () {
		$from = "travel";
		$travel = 0;
		$locations = array();
		$where = 'id_user = '.$this->user.' AND version = '.$this->version;
		$_SESSION['SO']->setBBDD('PANEL');
		$result = $_SESSION['SO']->select ($from, '*', $where);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			if (!in_array($row['location'], $locations)) {
				$locations[] = strtolower($row['location']);
				//TIEMPO
				if (isset($row['start_date']) && $row['start_date'] != '' && $row['start_date'] != '0000-00-00'){
					if (isset($row['end_date']) && $row['end_date'] != '' && $row['end_date'] != '0000-00-00') {
						$months = $this->getDiffTime($row['start_date'], $row['end_date'], 'm');
					} else {
						$months = $this->getDiffTime($row['start_date'], 'now', 'm');
					}
					if ($months < 2)
						$time = 2;
					else if ($months < 4)
						$time = 4;
					else if (months < 7)
						$time = 6;
					else if (months < 13)
						$time = 8;
					else if (months >= 13)
						$time = 10;
				}
				$travel = travel + ($time * 0.1);
			}
		}
		if ($travel >= 10)
			$travel = 10;
		
		return $travel;
	}
	
	private function languageLevel () {
		$from = "language";
		$language = 0;
		$languages = array();
		$where = 'id_user = '.$this->user.' AND version = '.$this->version;
		$_SESSION['SO']->setBBDD('PANEL');
		$result = $_SESSION['SO']->select ($from, '*', $where);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			$certificate = 0;
			$level = 0;
			if (!in_array($row['name'], $locations)) {
				$languages[] = strtolower($row['name']);
				//CERTIFICADO
				if ($row['certificate'] != '' && isset($row['certificate']))
					$certificate = 10;
				//NIVEL
				switch ($row['level']) {
					case 0:
						$level = 2;
						break;
					case 1:
						$level = 4;
						break;
					case 2:
						$level = 6;
						break;
					case 3:
						$level = 8;
						break;
					case 4:
						$level = 10;
						break;
				}
				$language = $language + ((($certificate * 0.2) + ($level * 0.8)) * (1/3));
			}
		}
		if ($language >= 10)
			$language = 10;
		
		return $language;
	}
	
	private function setNameSectors () {
		$where = 'state = 1';
		$_SESSION['SO']->setBBDD('DATA');
		$result = $_SESSION['SO']->select('sector', '*', $where);
		for($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			$this->name_sectors[$row['id_sector']] = $row['name'];
		}
		$_SESSION['SO']->setBBDD('PANEL');
	}
	
	private function sectors () {
		$this->setNameSectors();
		$this->sectors = array();
		$this->educationSectors();
		$this->skillSectors();
		$this->workSectors();
		$this->proyectSectors();
		$this->activitySectors();
		$this->publications();
	}
	
	public function printSectors () {
		if ($this->domain != '') {
			$this->sectors();
			$json = array();
			foreach ($this->sectors as $k => $v) {
				$json[] = array(
					"title" => $this->name_sectors[$k],
					"subtitle" => '',
					"ranges" => array(
						0 => 100
					),
					"measures" => array(
						0 => $v*10,
						1 => 100	
					),
					"markers" => array(
						0 => $v*10
					)
				);
			}
			$json = json_encode($json);
			$_SESSION['brain'] = $json;
			$txt = $txt . file_get_contents('Programs/Brain/graphics/sectors.php');
		} else 
			$txt = 'Necesitas definir el usuario: domain name_user';
		
		return $txt;
	}
	
	private function getGeneralCulture () {
		$this->sectors();
		$total_sectors = 0;
		foreach ($this->sectors as $k => $v) {
			$total_sectors = $total_sectors + $v;
		}
		if ($total_sectors >= 10)
			$total_sectors = 10;
		$culture = $this->culturalLevel();
		$art = $this->artisticLevel();
		$education = $this->educationLevel();
		$travel = $this->locationLevel();
		$language = $this->languageLevel();
		$generalCulture = ($total_sectors * 0.25) + ($culture * 0.2) + ($art * 0.1) + ($education * 0.2) + ($travel * 0.15) + ($language * 0.1);
		
		return $generalCulture;
	}
	
	public function printGeneralCulture () {
		if ($this->domain != '') {
			$json = array();
			$this->sectors();
			$total_sectors = 0;
			foreach ($this->sectors as $k => $v) {
				$total_sectors = $total_sectors + ($v * (1/3));
			}
			if ($total_sectors >= 10)
				$total_sectors = 10;
			$json[] = array(
					"title" => "Sectores",
					"subtitle" => 'Nivel',
					"ranges" => array(
							0 => 100
					),
					"measures" => array(
							0 => $total_sectors*10,
							1 => 100
					),
					"markers" => array(
							0 => $total_sectors*10
					)
			);
			$culture = $this->culturalLevel();
			$json[] = array(
					"title" => "Cultura",
					"subtitle" => 'Nivel',
					"ranges" => array(
							0 => 100
					),
					"measures" => array(
							0 => $culture*10,
							1 => 100
					),
					"markers" => array(
							0 => $culture*10
					)
			);
			$art = $this->artisticLevel();
			$json[] = array(
					"title" => "Arte",
					"subtitle" => 'Nivel',
					"ranges" => array(
							0 => 100
					),
					"measures" => array(
							0 => $art*10,
							1 => 100
					),
					"markers" => array(
							0 => $art*10
					)
			);
			$education = $this->educationLevel();
			$json[] = array(
					"title" => "Formación",
					"subtitle" => 'Nivel',
					"ranges" => array(
							0 => 100
					),
					"measures" => array(
							0 => $education*10,
							1 => 100
					),
					"markers" => array(
							0 => $education*10
					)
			);
			$travel = $this->locationLevel();
			$json[] = array(
					"title" => "Viajes",
					"subtitle" => 'Nivel',
					"ranges" => array(
							0 => 100
					),
					"measures" => array(
							0 => $travel*10,
							1 => 100
					),
					"markers" => array(
							0 => $travel*10
					)
			);
			$language = $this->languageLevel();
			$json[] = array(
					"title" => "Idiomas",
					"subtitle" => 'Nivel',
					"ranges" => array(
							0 => 100
					),
					"measures" => array(
							0 => $language*10,
							1 => 100
					),
					"markers" => array(
							0 => $language*10
					)
			);
			$json = json_encode($json);
			$_SESSION['brain'] = $json;
			$txt = $txt . file_get_contents('Programs/Brain/graphics/sectors.php');
		} else 
			$txt = 'Necesitas definir el usuario: domain name_user';
		
		return $txt;
	}
	
	private function getLevelReading ($genre) {
		$reading = 0;
		$from = "mtlculture";
		$where = 'id_user = '.$this->user.' AND version = '.$this->version.' AND category = "Lectura" AND genre = "'.$genre.'"';
		$_SESSION['SO']->setBBDD('PANEL');
		$result = $_SESSION['SO']->select ($from, '*', $where);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$review = 0;
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			//REVIEW
			if ($row['description'] != '' && isset($row['description']))
				$review = 10;
			$reading = $reading + ((($review * 0.4) + 6) * 0.2);
		}
		if ($reading >= 10)
			$reading = 10;
		
		return $reading;
	}
	
	private function getLevelSectors ($category) {
		$this->sectors();
		$sectors = 0;
		$tic_sectors = array("Desarrollo de programación", "Equipos informáticos", "Interconexión en red", "Internet", "Producción multimedia", "Diseño gráfico", "Programas informáticos", "Seguridad del ordenador y de las redes", "Servicios y tecnologías de la información", "Tecnología inalámbrica", "Telecomunicaciones");
		$marketing_sectors = array("Animación", "Desarrollo y comercio internacional", "Investigación de mercado", "Marketing y publicidad", "Relaciones públicas y comunicaciones", "Resolución de conflictos por terceras partes","Servicio de información", "Venta al por mayor", "Venta al por menor");
		$creativity_sectors = array("Artes escénicas", "Bellas Artes", "Arquitectura y planificación", "Diseño", "Diseño gráfico", "Fotografía", "Música", "Películas y cine", "Producción multimedia");
		$items = array();
		switch ($category) {
			case "creativity":
				$items = $creativity_sectors;
				break;
			case "marketing":
				$items = $marketing_sectors;
				break;
			case "tic":
				$items = $tic_sectors;
				break;
		}
		foreach ($this->sectors as $k =>$v) {
			if (in_array($this->name_sectors[$k], $items)) {
				$sectors = $sectors + $v;
			}
		}
		if ($sectors >= 10)
			$sectors = 10;
		
		return $sectors;
	}
	
	private function getCreativity () {
		$sectors = $this->getLevelSectors("creativity");
		$art = $this->artisticLevel();
		$culture = $this->getLevelReading("Diseño/Creatividad");
		$creativity = ($sectors * 0.5) + ($art * 0.4) + ($culture * 0.1);
		
		return $creativity;
	}
	
	public function printCreativity () {
		if ($this->domain != '') {
			$json = array();
			$sectors = $this->getLevelSectors("creativity");
			$json[] = array(
					"title" => "Sectores",
					"subtitle" => 'Relacionados con creatividad',
					"ranges" => array(
							0 => 100
					),
					"measures" => array(
							0 => $sectors*10,
							1 => 100
					),
					"markers" => array(
							0 => $sectors*10
					)
			);
			$art = $this->artisticLevel();
			$json[] = array(
					"title" => "Nivel Artístico",
					"subtitle" => 'Nivel',
					"ranges" => array(
							0 => 100
					),
					"measures" => array(
							0 => $art*10,
							1 => 100
					),
					"markers" => array(
							0 => $art*10
					)
			);
			$culture = $this->getLevelReading("Diseño/Creatividad");
			$json[] = array(
					"title" => "Cultura",
					"subtitle" => 'Nivel de lectura',
					"ranges" => array(
							0 => 100
					),
					"measures" => array(
							0 => $culture*10,
							1 => 100
					),
					"markers" => array(
							0 => $culture*10
					)
			);
			$json = json_encode($json);
			$_SESSION['brain'] = $json;
			$txt = $txt . file_get_contents('Programs/Brain/graphics/sectors.php');
		} else 
			$txt = 'Necesitas definir el usuario: domain name_user';
		
		return $txt;
	}
	
	private function getVolunteering () {
		$volunteering = 0;
		$from = "experience";
		$where = 'id_user = '.$this->user.' AND version = '.$this->version.' AND type = 9';
		$_SESSION['SO']->setBBDD('PANEL');
		$result = $_SESSION['SO']->select ($from, '*', $where);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$time = 0;
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			//TIEMPO
			if (isset($row['start_date']) && $row['start_date'] != '' && $row['start_date'] != '0000-00-00'){
				if (isset($row['end_date']) && $row['end_date'] != '' && $row['end_date'] != '0000-00-00') {
					$years = $this->getDiffTime($row['start_date'], $row['end_date'], 'y');
					$months = $this->getDiffTime($row['start_date'], $row['end_date'], 'm') + ($years * 12);
				} else {
					$years = $this->getDiffTime($row['start_date'], 'now', 'y');
					$months = $this->getDiffTime($row['start_date'], 'now', 'm') + ($years * 12);
				}
				if ($months < 4) {
					$time = 2;
				} else if ($months < 7) {
					$time = 4;
				} else if ($months < 13) {
					$time = 6;
				} else if ($months < 25) {
					$time = 8;
				} else if ($months >= 25) {
					$time = 10;
				}
			}
			$volunteering = $volunteering + $time;
		}
		$from = "activity";
		$where = 'id_user = '.$this->user.' AND version = '.$this->version.' AND category = 2';
		$_SESSION['SO']->setBBDD('PANEL');
		$result = $_SESSION['SO']->select ($from, '*', $where);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			$volunteering = $volunteering + 1;
		}
		if ($volunteering >= 10)
			$volunteering = 10;
		
		return $volunteering;
	}
	
	private function getMarketing () {
		$sectors = $this->getLevelSectors("marketing");
		$culture = $this->getLevelReading("Marketing y ventas");
		$volunteering = $this->getVolunteering();
		$marketing = ($sectors * 0.8) + ($volunteering * 0.1) + ($culture * 0.1);
		
		return $marketing;
	}
	
	public function printMarketing () {
		if ($this->domain != '') {
			$json = array();
			$sectors = $this->getLevelSectors("marketing");
			$json[] = array(
					"title" => "Sectores",
					"subtitle" => 'Relacionados con marketing y ventas',
					"ranges" => array(
							0 => 100
					),
					"measures" => array(
							0 => $sectors*10,
							1 => 100
					),
					"markers" => array(
							0 => $sectors*10
					)
			);
			$volunteering = $this->getVolunteering();
			$json[] = array(
					"title" => "Voluntariado",
					"subtitle" => 'Nivel',
					"ranges" => array(
							0 => 100
					),
					"measures" => array(
							0 => $volunteering*10,
							1 => 100
					),
					"markers" => array(
							0 => $volunteering*10
					)
			);
			$culture = $this->getLevelReading("Marketing y ventas");
			$json[] = array(
					"title" => "Cultura",
					"subtitle" => 'Nivel de lectura',
					"ranges" => array(
							0 => 100
					),
					"measures" => array(
							0 => $culture*10,
							1 => 100
					),
					"markers" => array(
							0 => $culture*10
					)
			);
			$json = json_encode($json);
			$_SESSION['brain'] = $json;
			$txt = $txt . file_get_contents('Programs/Brain/graphics/sectors.php');
		} else 
			$txt = 'Necesitas definir el usuario: domain name_user';
		
		return $txt;
	}
	
	private function getTIC () {
		$sectors = $this->getLevelSectors("tic");
		$culture = $this->getLevelReading("Tecnológico");
		$volunteering = $this->getVolunteering();
		$tic = ($sectors * 0.8) + ($culture * 0.2);
	
		return $tic;
	}
	
	public function printTIC () {
		if ($this->domain != '') {
			$json = array();
			$sectors = $this->getLevelSectors("tic");
			$json[] = array(
					"title" => "Sectores",
					"subtitle" => 'Relacionados con TIC',
					"ranges" => array(
							0 => 100
					),
					"measures" => array(
							0 => $sectors*10,
							1 => 100
					),
					"markers" => array(
							0 => $sectors*10
					)
			);
			$culture = $this->getLevelReading("Tecnológico");
			$json[] = array(
					"title" => "Cultura",
					"subtitle" => 'Nivel de lectura',
					"ranges" => array(
							0 => 100
					),
					"measures" => array(
							0 => $culture*10,
							1 => 100
					),
					"markers" => array(
							0 => $culture*10
					)
			);
			$json = json_encode($json);
			$_SESSION['brain'] = $json;
			$txt = $txt . file_get_contents('Programs/Brain/graphics/sectors.php');
		} else 
			$txt = 'Necesitas definir el usuario: domain name_user';
		
		return $txt;
	}
	
	public function printCapabilities () {
		if ($this->domain != '') {
			$json = array();
			$generalCulture = $this->getGeneralCulture();
			$percent = round(($generalCulture*10),2);
			$percent = $percent.'%';
			$json[] = array(
					"title" => "Cultura General",
					"subtitle" => $percent,
					"ranges" => array(
							0 => 100
					),
					"measures" => array(
							0 => $generalCulture*10,
							1 => 100
					),
					"markers" => array(
							0 => $generalCulture*10
					)
			);
			$creativity = $this->getCreativity();
			$percent = round(($creativity*10),2);
			$percent = $percent.'%';
			$json[] = array(
					"title" => "Creatividad",
					"subtitle" => $percent,
					"ranges" => array(
							0 => 100
					),
					"measures" => array(
							0 => $creativity*10,
							1 => 100
					),
					"markers" => array(
							0 => $creativity*10
					)
			);
			$marketing = $this->getMarketing();
			$percent = round(($marketing*10),2);
			$percent = $percent.'%';
			$json[] = array(
					"title" => "Marketing y Ventas",
					"subtitle" => $percent,
					"ranges" => array(
							0 => 100
					),
					"measures" => array(
							0 => $marketing*10,
							1 => 100
					),
					"markers" => array(
							0 => $marketing*10
					)
			);
			$tic = $this->getTIC();
			$percent = round(($tic*10),2);
			$percent = $percent.'%';
			$json[] = array(
					"title" => "Manejo de las TIC",
					"subtitle" => $percent,
					"ranges" => array(
							0 => 100
					),
					"measures" => array(
							0 => $tic*10,
							1 => 100
					),
					"markers" => array(
							0 => $tic*10
					)
			);
			$json = json_encode($json);
			$_SESSION['brain'] = $json;
			$txt = $txt . file_get_contents('Programs/Brain/graphics/sectors.php');
		} else 
			$txt = 'Necesitas definir el usuario: domain name_user';
		
		return $txt;
	}
	
	public function emotionalIntelligence () {
		if ($this->domain != '') {
			$json = array();
			$volunteering = $this->getVolunteering();
			$percent = round(($volunteering*10),2);
			$percent = $percent.'%';
			$json[] = array(
					"title" => "Voluntariado",
					"subtitle" => $percent,
					"ranges" => array(
							0 => 100
					),
					"measures" => array(
							0 => $volunteering*10,
							1 => 100
					),
					"markers" => array(
							0 => $volunteering*10
					)
			);
			$json = json_encode($json);
			$_SESSION['brain'] = $json;
			$txt = $txt . file_get_contents('Programs/Brain/graphics/sectors.php');
			$from = "upgrade";
			$where = 'id_user = '.$this->user.' AND version = '.$this->version;
			$_SESSION['SO']->setBBDD('PANEL');
			$result = $_SESSION['SO']->select ($from, '*', $where);
			$row = $result->fetch_assoc();
			$txt = $txt.'<h4>¿Cómo afrontarías la situación?</h4>';
			$txt = $txt.'<div class = "texto"><label>Tienes que dar una mala notica a alguien</label>'.html_entity_decode($row['badnew']).'</div>';
			$txt = $txt.'<div class = "texto"><label>Estás muy agobiado porque tienes mucho trabajo</label>'.html_entity_decode($row['overloaded'].'</div>');
		} else 
			$txt = 'Necesitas definir el usuario: domain name_user';
		
		return $txt;
	}
	
	public function setDomain ($domain) {
		if ($this->getUser($domain))
			$this->message = 'Usuario definido.';
		else {
			$this->message = 'El usuario no existe.';
			$this->domain = '';
		}
	}
	
	private function numUsers () {
		$from = "user";
		$_SESSION['SO']->setBBDD('PANEL');
		$result = $_SESSION['SO']->select ($from, '*');
		return $result->num_rows;
	}
	
	//GRAFOS DE RELACIONES
	
	private function extractWork () {
		$works = array();
		$from = "experience";
		$where = 'id_user = '.$this->user.' AND version = '.$this->version;
		$_SESSION['SO']->setBBDD('PANEL');
		$result = $_SESSION['SO']->select ($from, '*', $where);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			$works[$row['id_experience']] = $row['position'].' en '.$row['company'];
		}
		return $works;
	}
	
	private function extractEducation () {
		$education = array();
		$from = "education";
		$where = 'id_user = '.$this->user.' AND version = '.$this->version;
		$qualifications = array("Otros títulos", "Enseñanza Secundaria", "Enseñanza Superior", "FP Media", "FP Superior", "Licenciatura", "Grado", "Ingeniería técnica", "Ingeniería superior", "Curso", "Máster", "Doctorado");
		$_SESSION['SO']->setBBDD('PANEL');
		$result = $_SESSION['SO']->select ($from, '*', $where);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			$education[$row['id_education']] = $qualifications[$row['qualification']].' de '.$row['titulation'];
		}
		return $education;
	}
	
	private function extractLanguage () {
		$language = array();
		$from = "language";
		$where = 'id_user = '.$this->user.' AND version = '.$this->version;
		$_SESSION['SO']->setBBDD('PANEL');
		$result = $_SESSION['SO']->select ($from, '*', $where);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			$language[$row['id_language']] = $row['name'];
		}
		return $language;
	}
	
	private function extractSkill () {
		$skill = array();
		$from = "skill";
		$where = 'id_user = '.$this->user.' AND version = '.$this->version;
		$_SESSION['SO']->setBBDD('PANEL');
		$result = $_SESSION['SO']->select ($from, '*', $where);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			$skill[$row['id_skill']] = $row['name'];
		}
		return $skill;
	}
	
	private function extractActivity () {
		$activity = array();
		$types = array("No sé", "Evento", "Voluntariado", "Innovación/Emprendimiento", "Trabajo en equipo", "Hablar en público", "Organización y planificación");
		$from = "activity";
		$where = 'id_user = '.$this->user.' AND version = '.$this->version;
		$_SESSION['SO']->setBBDD('PANEL');
		$result = $_SESSION['SO']->select ($from, '*', $where);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			switch ($row['category']) {
				case 0 :
					if (isset($activity[$types[0]]))
						$activity[$types[0]][$row['id_activity']] = $row['title'];
					else {
						$activity[$types[0]] = array();
						$activity[$types[0]][$row['id_activity']] = $row['title'];
					}
					break;
				case 1 :
					if (isset($activity[$types[1]]))
						$activity[$types[1]][$row['id_activity']] = $row['title'];
					else {
						$activity[$types[1]] = array();
						$activity[$types[1]][$row['id_activity']] = $row['title'];
					}
					break;
				case 2 :
					if (isset($activity[$types[2]])) {
						$activity[$types[2]][$row['id_activity']] = $row['title'];
					} else {
						$activity[$types[2]] = array();
						$activity[$types[2]][$row['id_activity']] = $row['title'];
					}
					break;
				case 3 :
					if (isset($activity[$types[3]])) {
						$activity[$types[3]][$row['id_activity']] = $row['title'];
					} else {
						$activity[$types[3]] = array();
						$activity[$types[3]][$row['id_activity']] = $row['title'];
					}
					break;
				case 4 :
					if (isset($activity[$types[4]]))
						$activity[$types[4]][$row['id_activity']] = $row['title'];
					else {
						$activity[$types[4]] = array();
						$activity[$types[4]][$row['id_activity']] = $row['title'];
					}
					break;
				case 5 :
					if (isset($activity[$types[5]]))
						$activity[$types[5]][$row['id_activity']] = $row['title'];
					else {
						$activity[$types[5]] = array();
						$activity[$types[5]][$row['id_activity']] = $row['title'];
					}
					break;
				case 6 :
					if (isset($activity[$types[6]]))
						$activity[$types[6]][$row['id_activity']] = $row['title'];
					else {
						$activity[$types[6]] = array();
						$activity[$types[6]][$row['id_activity']] = $row['title'];
					}
					break;
			}
		}
		return $activity;
	}
	
	private function extractProyect () {
		$proyect = array();
		$types = array("No propios", "Propios");
		$from = "proyect";
		$where = 'id_user = '.$this->user.' AND version = '.$this->version;
		$_SESSION['SO']->setBBDD('PANEL');
		$result = $_SESSION['SO']->select ($from, '*', $where);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			switch ($row['self']) {
				case 0 :
					if (isset($proyect[$types[0]]))
						$proyect[$types[0]][$row['id_proyect']] = $row['title'];
						else {
							$proyect[$types[0]] = array();
							$proyect[$types[0]][$row['id_proyect']] = $row['title'];
						}
						break;
				case 1 :
					if (isset($proyect[$types[1]]))
						$proyect[$types[1]][$row['id_proyect']] = $row['title'];
						else {
							$proyect[$types[1]] = array();
							$proyect[$types[1]][$row['id_proyect']] = $row['title'];
						}
						break;
			}
		}
		return $proyect;
	}
	
	private function extractArt () {
		$art = array();
		$categories = array();
		$from = "mtlart";
		$where = 'id_user = '.$this->user.' AND version = '.$this->version;
		$_SESSION['SO']->setBBDD('PANEL');
		$result = $_SESSION['SO']->select ($from, '*', $where);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			if (!in_array($row['category'], $categories)) {
				$categories[] = $row['category'];
				$art[$row['id_mtlart']] = $row['category'];
			}
		}
		return $art;
	}
	
	private function extractCulture () {
		$culture = array();
		$categories = array();
		$from = "mtlculture";
		$where = 'id_user = '.$this->user.' AND version = '.$this->version;
		$_SESSION['SO']->setBBDD('PANEL');
		$result = $_SESSION['SO']->select ($from, '*', $where);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			if (!in_array($row['category'], $categories)) {
				$categories[] = $row['category'];
				$culture[$row['id_mtlculture']] = $row['category'];
			}
		}
		return $culture;
	}
	
	private function extractGeek () {
		$geek = array();
		$categories = array();
		$from = "mtlgeek";
		$where = 'id_user = '.$this->user.' AND version = '.$this->version;
		$_SESSION['SO']->setBBDD('PANEL');
		$result = $_SESSION['SO']->select ($from, '*', $where);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			if (!in_array($row['category'], $categories)) {
				$categories[] = $row['category'];
				$geek[$row['id_mtlgeek']] = $row['category'];
			}
		}
		return $geek;
	}
	
	private function extractSport () {
		$sport = array();
		$categories = array();
		$from = "mtlsport";
		$where = 'id_user = '.$this->user.' AND version = '.$this->version;
		$_SESSION['SO']->setBBDD('PANEL');
		$result = $_SESSION['SO']->select ($from, '*', $where);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			if (!in_array($row['category'], $categories)) {
				$categories[] = $row['category'];
				$sport[] = $row['category'];
			}
		}
		return $sport;
	}
	
	private function extractBlog () {
		$blog = array();
		$from = "blog";
		$where = 'id_user = '.$this->user.' AND version = '.$this->version;
		$_SESSION['SO']->setBBDD('PANEL');
		$result = $_SESSION['SO']->select ($from, '*', $where);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			$blog[$row['id_blog']] = $row['name'];
		}
		return $blog;
	}
	
	private function extractForum () {
		$forum = array();
		$from = "forum";
		$where = 'id_user = '.$this->user.' AND version = '.$this->version;
		$_SESSION['SO']->setBBDD('PANEL');
		$result = $_SESSION['SO']->select ($from, '*', $where);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			$forum[$row['id_forum']] = $row['name'];
		}
		return $forum;
	}
	
	private function extractArticle () {
		$article = array();
		$from = "article";
		$where = 'id_user = '.$this->user.' AND version = '.$this->version;
		$_SESSION['SO']->setBBDD('PANEL');
		$result = $_SESSION['SO']->select ($from, '*', $where);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			$article[$row['id_article']] = $row['title'];
		}
		return $article;
	}
	
	private function genArrayRelation ($item) {
		$array = array();
		foreach ($item as $k => $v) {
			$array[] = array(
				"name" => $v
			);
		}
		return $array;
	}
	
	public function printRelation () {
		if ($this->domain != '') {
			$txt = '';
			$works = $this->extractWork();
			$works_array = $this->genArrayRelation($works);
			$education = $this->extractEducation();
			$education_array = $this->genArrayRelation($education);
			$language = $this->extractLanguage();
			$language_array = $this->genArrayRelation($language);
			$skill = $this->extractSkill();
			$skill_array = $this->genArrayRelation($skill);
			//ACTIVIDADES
			$activity = $this->extractActivity();
			$activity_array = array();
			$activity_array2 = array();
			$activity_count = 0;
			foreach ($activity as $k => $v) {
				foreach ($v as $key => $value) {
					$activity_array2[] = array(
						"name" => $value
					);
				}
				$activity_array[] = array(
					"name" => $k,
					"children" => $activity_array2
				);
				$activity_count++;
				unset($activity_array2);
			}
			//PROYECTOS
			$proyect = $this->extractProyect();
			$proyect_array = array();
			$proyect_array2 = array();
			$proyect_count = 0;
			foreach ($proyect as $k => $v) {
				foreach ($v as $key => $value) {
					$proyect_array2[] = array(
						"name" => $value
					);
				}
				$proyect_array[] = array(
					"name" => $k,
					"children" => $proyect_array2
				);
				$proyect_count++;
				unset($proyect_array2);
			}
			//PUBLICACIONES
			$blog = $this->extractBlog();
			$forum = $this->extractForum();
			$article = $this->extractArticle();
			$publications = array();
			$blog_array = array();
			foreach ($blog as $k => $v) {
				$blog_array[] = array(
						"name" => $v
				);
			}
			$publications[] = array (
				"name" => "Blogs",
				"children" => $blog_array
			);
			$forum_array = array();
			foreach ($forum as $k => $v) {
				$forum_array[] = array(
					"name" => $v
				);
			}
			$publications[] = array (
				"name" => "Foros",
				"children" => $forum_array
			);
			$article_array = array();
			foreach ($article as $k => $v) {
				$article_array[] = array(
					"name" => $v
				);
			}
			$publications[] = array (
				"name" => "Artículos",
				"children" => $article_array
			);
			//MI TIEMPO LIBRE
			$art = $this->extractArt();
			$culture = $this->extractCulture();
			$geek = $this->extractgeek();
			$sport = $this->extractSport();
			$mtl = array();
			$art_array = array();
			foreach ($art as $k => $v) {
				$art_array[] = array(
						"name" => $v
				);
			}
			$mtl[] = array (
				"name" => "Arte",
				"children" => $art_array
			);
			$culture_array = array();
			foreach ($culture as $k => $v) {
				$culture_array[] = array(
						"name" => $v
				);
			}
			$mtl[] = array (
				"name" => "Cultura",
				"children" => $culture_array
			);
			$geek_array = array();
			foreach ($geek as $k => $v) {
				$geek_array[] = array(
						"name" => $v
				);
			}
			$mtl[] = array (
				"name" => "Friki",
				"children" => $geek_array
			);
			$sport_array = array();
			foreach ($sport as $k => $v) {
				$sport_array[] = array(
						"name" => $v
				);
			}
			$mtl[] = array (
					"name" => "Deporte",
					"children" => $sport_array
			);
			$json = array(
				"name" => $this->domain,
				"children" => array(
					0 => array(
						"name" => "Trabajos",
						"children" => $works_array
					),
					1 => array(
						"name" => "Formación",
						"children" => $education_array
					),
					2 => array(
						"name" => "Idiomas",
						"children" => $language_array
					),
					3 => array(
						"name" => "Habilidades",
						"children" => $skill_array
					),
					4 => array(
						"name" => "Actividades",
						"children" => $activity_array
					),
					5 => array(
						"name" => "Proyectos",
						"children" => $proyect_array
					),
					6 => array(
						"name" => "Mi Tiempo Libre",
						"children" => $mtl
					),
					7 => array(
						"name" => "Publicaciones",
						"children" => $publications
					)
				)
			);
			$json = json_encode($json);
			$_SESSION['brain'] = $json;
			$txt = $txt . file_get_contents('Programs/Brain/graphics/collapsible_tree.php');
		} else
			$txt = 'Necesitas definir el usuario: domain name_user';
		return $txt;
	}
 }