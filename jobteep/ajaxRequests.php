<?php
header('Content-Type: text/html; charset=UTF-8');
require_once 'SO/SO.class.php';
session_start();

$controller = $_SESSION['SO']->getController();
if (isset($_POST['action']))
	$action = $_POST['action'];
else if (isset($_GET['action']))
	$action = $_GET['action'];

switch ($action) {
	case 'register':
		sleep(1);
		if ($controller->userExist($_POST['user']))
			echo '<span class = "label alert expand">No disponible</span>';
		else
			echo '<span class = "label success expand">Disponible</span>';
		break;
	case 'city':
		$loc = $controller->setParamsLocation ($_POST['direction']);
		$city = $loc->get('city');
		echo $city;
		break;
	case 'country':
		$loc = $controller->setParamsLocation ($_POST['direction']);
		$country = $loc->get('country');
		echo $country;
		break;
	case 'location':
		try {
			$resultado = file_get_contents(sprintf('https://maps.googleapis.com/maps/api/geocode/json?sensor=false&address=%s', urlencode($_POST['direction'])));
			$resultado = json_decode($resultado, TRUE);
			$city = $resultado['results'][0]['address_components']['4']['long_name'];
			$country = $resultado['results'][0]['address_components']['5']['long_name'];
			if ($country == "Spain")
				$country = "España";
			echo $city.','.$country;
		} catch (Exception $e) {
			
		}
		break;
	case 'latlng':
		try {
			$resultado = file_get_contents(sprintf('https://maps.googleapis.com/maps/api/geocode/json?sensor=false&address=%s', urlencode($_POST['direction'])));
			$resultado = json_decode($resultado, TRUE);
			$latitude = $resultado['results'][0]['geometry']['location']['lat'];
			$longitude = $resultado['results'][0]['geometry']['location']['lng'];
			echo $latitude.','.$longitude;
		} catch (Exception $e) {
			
		}
		break;
	case 'lng':
		$resultado = file_get_contents(sprintf('https://maps.googleapis.com/maps/api/geocode/json?sensor=false&address=%s', urlencode($_POST['direction'])));
		$resultado = json_decode($resultado, TRUE);

		$longitude = $resultado['results'][0]['geometry']['location']['lng'];
		echo $longitude;
		break;
	case 'domain':
		sleep(1);
		if ($controller->domainExist($_POST['domain']))
			echo '<font color = "red">No disponible</font>';
		else
			echo '<font color = "green">Disponible</font>';
		break;
	case 'subsector':
		$where = 'id_'.$_POST['enum'].'sector = '.$_POST['q'];
		$result = $controller->getData($_POST['enum'].'subsector', $where);
		echo '<datalist id = "subsectors">';
		for($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			echo '<option value = "'.$row['name'].'">';
		}
		echo '</datalist>';
		break;
	case 'find':
		$where = 'name LIKE "%'.$_GET['q'].'%"';
		$from = '*';
		$order = 'name ASC';
		$result = $controller->getData($_GET['enum'], $where, $order, $from);
		for($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			echo '<option value = "'.$row['name'].'">';
		}
		break;
	case 'lnkdn':
		$enums = array("experience", "education", "language", "skill", "proyect");
		$campos = array(
			"experience" => array(
				0 => "company", 
				1 => "position", 
				2 => "start_date", 
				3 => "end_date", 
				4 => "description"
			),
			"education" => array(
				0 => "titulation",
				1 => "nameCenter",
				2 => "start_date",
				3 => "end_date",
				4 => "description"
			),
			"language" => array(
				0 => "name"
			),
			"skill" => array(
				0 => "name"
			),
			"proyect" => array(
				0 => "title",
				1 => "description"
			),
		);
		/*$controller->setEnum($_POST['enum']);*/
		$experience = json_decode(stripslashes($_POST['experience']));
		$education = json_decode(stripslashes($_POST['education']));
		$language = json_decode(stripslashes($_POST['language']));
		$skill = json_decode(stripslashes($_POST['skill']));
		$proyect = json_decode(stripslashes($_POST['proyect']));
		$elementos = array($experience, $education, $language, $skill, $proyect);
		for ($j = 0; $j < count($enums); $j++) {
			$controller->setEnum($enums[$j]);
			foreach ($elementos[$j] as $k => $v) {
				$elemento = array();
				$nombres = $campos[$enums[$j]];
				for ($i = 0; $i < count($nombres); $i++) {
					if ($nombres[$i] == 'description')
						$elemento[$nombres[$i]] = htmlentities($v[$i], ENT_QUOTES, 'UTF-8');
					else 
						$elemento[$nombres[$i]] = $v[$i];
				}
				$controller->insertLinkedin ($elemento);
				unset($elemento);
				unset($nombres);
			}
		}
		/*foreach ($data as $k => $v) {
			$elemento = array();
			$nombres = $campos[$_POST['enum']];
			for ($i = 0; $i < count($nombres); $i++) {
				$elemento[$nombres[$i]] = htmlentities($v[$i], ENT_QUOTES, 'UTF-8');
			}
			$controller->insertElement ($elemento);
		}*/
		break;
}
?>