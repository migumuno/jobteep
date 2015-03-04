<?php 
if (isset($proyect['start_date']))
	$fecha_ini = $proyect['start_date'];
else 
	$fecha_ini = '';
if (isset($proyect['end_date']))
	$fecha_fin = $proyect['end_date'];
else
	$fecha_fin = '';
$niveles_idiomas = array("A2", "B1", "B2", "C1", "C2");
function orderImages ($num) {
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

function getTime ($start, $end) {
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
		$annos = $datetime2->format('y') - $datetime1->format('y');
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
?>
<div class = "medium-12 columns">
	<div class = "dos_columnas show-for-medium-up">
		<?php echo html_entity_decode($proyect['description']) ?>
		<p>Duración: <?php echo getTime ($fecha_ini, $fecha_fin) ?></p>
		<p>
		<?php
		if (isset($proyect['language'])) {
			$language = $proyect['language'];
			if (count($language) != 0) {
				for ($l = 0; $l < count($language); $l++) {
					echo '<span class = "label">'.$language[$l]['name'].': '.$niveles_idiomas[$language[$l]['level']].'</span>&nbsp';
				}	
			}
		}?>
		</p>
	</div>
	<div class = "unacolumna show-for-small">
		<?php echo html_entity_decode($proyect['description']) ?>
		<p>Duración: <?php echo getTime ($fecha_ini, $fecha_fin) ?></p>
		<p>
		<?php
		if (isset($proyect['language'])) {
			$language = $proyect['language'];
			if (count($language) != 0) {
				for ($l = 0; $l < count($language); $l++) {
					echo '<span class = "label">'.$language[$l]['name'].': '.$niveles_idiomas[$language[$l]['level']].'</span>&nbsp';
				}	
			}
		}?>
		</p>
	</div>
</div>
<div class = "relleno"></div>
<?php 
if (isset($proyect['images'])) {
	$imagenes = $proyect['images'];
	if (count($imagenes) != 0) {
		$array = orderImages(count($imagenes));
		echo '<div class = "imagenes_definicion">';
		for ($s = 0; $s < count($imagenes); $s++) {
			echo '<a href = "Data/Users/'.$_POST['dirname'].'/'.$imagenes[$s]['file'].'" data-lightbox="project'.$_POST['id_proyect'].'" data-title="'.$imagenes[$s]['name'].'<br><br>'.$imagenes[$s]['description'].'"><div id = "imagen_proyecto'.$imagenes[$s]['id_proyectimg'].'" class = "medium-'.$array[$s].' columns fondo_imagen_proyecto_definicion"></div></a>';
			echo '<script>document.getElementById(\'imagen_proyecto'.$imagenes[$s]['id_proyectimg'].'\').style.backgroundImage="url(\'Data/Users/'.$_POST['dirname'].'/'.$imagenes[$s]['file'].'\')";</script>';
		}
		echo '<div class = "relleno"></div>';
		echo '</div>';
	}
}
?>
	