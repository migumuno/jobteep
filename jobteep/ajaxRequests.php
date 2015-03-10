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
	case 'teepcard':
		$info = $controller->getInfo($_GET['user']);
		
		header( "Content-type: image/png" );
		header ("Content-Disposition: inline; filename=teepcard");
		
		//VARIABLES
		$font_size = 200;
		$nombre = $info['name'];
		$apellidos = explode(' ', $info['surname']);
		$margin = array(
				"left" => "200",
				"top" => "400"
		);
		$distance = 2260;
		$width = 2700;
		$height = 3500;
		$font = 'Libraries/fonts/Sawasdee-Bold.ttf';
		
		//CREACIÓN DE IMAGEN CON COLOR DE FONDO
		/*$image = imagecreate($width, $height);
		$bg_color = imagecolorallocate($image, 201, 212, 111);*/
		
		//CREACIÓN DE IMAGEN CON IMAGEN DE FONDO
		$image = imagecreatetruecolor($width, $height);
		$bg = imagecreatefromjpeg('Libraries/ImgGenerator/colores.jpeg');
		imagecopy($image, $bg, 0, 0, 0, 0, imagesx($bg), imagesy($bg));
		
		//COLORES
		$negro = imagecolorallocate($image, 0, 0, 0);
		$jobteep_dark = imagecolorallocate($image, 76, 76, 76);
		$blanco = imagecolorallocate($image, 255, 255, 255);
		$gris = imagecolorallocate($image, 168, 168, 168);
		
		/*imagecolortransparent($image, $negro);*/
		
		//TEXTOS
		$text_color = $blanco;
		//Nombre
		imagefttext($image, $font_size, 0, $margin['left'], $margin['top'], $text_color, $font, $nombre);
		for ($i = 0; $i < count($apellidos); $i++)
			imagefttext($image, $font_size, 0, $margin['left'], $margin['top']*(2+$i), $text_color, $font, $apellidos[$i]);
		//Profesión
		$font_size = 80;
		$profesion = $info['profession'];
		$limit = 40;
		if (strlen($profesion) > $limit) {
			$profesion = explode(' ', $profesion);
			$end = false;
			$linea = 0;
			$txt = array(
				0 => '',
				1 => ''
			);
			for ($i = 0; $i < count($profesion); $i++) {
				while (!$end) {
					if ((strlen($txt[$linea]) + strlen($profesion[$i]) + 1) <= $limit) {
						if (strlen($txt[$linea]) == 0)
							$txt[$linea] = $profesion[$i];
						else 
							$txt[$linea] .= ' '.$profesion[$i];
						$end = true;
					} else {
						if ($linea == 0)
							$linea = 1;
						else 
							$end = true;
					}
				}
				$end = false;
			}
			imagefttext($image, $font_size, 0, $margin['left'], $distance, $text_color, $font, strtr(strtoupper(htmlspecialchars_decode($txt[0])), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"));
			imagefttext($image, $font_size, 0, $margin['left'], $distance + 180, $text_color, $font, strtr(strtoupper(htmlspecialchars_decode($txt[1])), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"));
		} else {
			imagefttext($image, $font_size, 0, $margin['left'], $distance, $text_color, $font, strtr(strtoupper(htmlspecialchars_decode($profesion)), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"));
			imagefttext($image, $font_size, 0, $margin['left'], $distance, $text_color, $font, '');
		}
		//Email
		$email = 'E: '.$info['email'];
		imagefttext($image, $font_size, 0, $margin['left'], $distance + (180*2), $text_color, $font, $email);
		//Jobteep
		$jobteep = 'J: /'.$info['domain'];
		imagefttext($image, $font_size, 0, $margin['left'], $distance + (180*3), $text_color, $font, $jobteep);
		//Teléfono
		$telf = 'T: '.$info['telf1'];
		imagefttext($image, $font_size, 0, $margin['left'], $distance + (180*4), $text_color, $font, $telf);
		//Jobteep url
		$telf = 'www.jobteep.com';
		$font_size = 60;
		$pos = ($width/2) - 339;
		imagefttext($image, $font_size, 0, $pos, $distance + (180*6), $blanco, $font, $telf);
		
		//IMPRESIÓN DE IMAGEN
		imagepng($image);
		imagedestroy($image);
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