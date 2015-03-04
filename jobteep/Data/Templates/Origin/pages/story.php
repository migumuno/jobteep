
	<a name="enlace"></a>
	<?php
	$niveles_idiomas = array("A2", "B1", "B2", "C1", "C2");
	$lan_level = array("BÁSICA", "BÁSICA LIMITADA", "BÁSICA PROFESIONAL", "PROF. COMPLETA", "BILINGÜE");
	$apt_level = array("APRENDIZ", "JUNIOR", "ESPECIALISTA", "MAESTRO", "GURÚ");
	if (count($timeline) > 1)
		$pos_map = 1;
	else 
		$pos_map = 0;
	
	if (count($timeline) < 3)
		$pos_languages = $pos_activities;
	else if (count($timeline) == 3)
		$pos_languages = 2;
	else if (count($timeline) > 3)
		$pos_languages = 3;
	
	if (count($timeline) < 5)
		$pos_skills = $pos_languages;
	else if (count($timeline) == 5)
		$pos_skills = 4;
	else if (count($timeline) > 5)
		$pos_skills = 5;
	
	if (count($timeline) < 7)
		$pos_activities = $pos_map;
	else if (count($timeline) == 7)
		$pos_activities = 6;
	else if (count($timeline) > 7)
		$pos_activities = 7;
	
	for ($i = 0; $i < count($timeline); $i++) {
		if ($i == 0)
			$estilo = 'highlight';
		else 
			$estilo = $timeline[$i]['type'];
		//Campos individuales
		switch ($timeline[$i]['type']) {
			case "education":
				$nombre = strtr(strtoupper($timeline[$i]['content']['titulation']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
				$centro = strtr(strtoupper($timeline[$i]['content']['nameCenter']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
				$tipo = $timeline[$i]['content']['qualification'];
				$certificado = $timeline[$i]['content']['certificate'];
				$titulo_first = '<b>ACTUALMENTE ESTOY FORMÁNDOME COMO </b> '.$nombre.' EN '.$centro;
				$titulo = $nombre;
				$titulo2 = $centro;
				$place = 'CENTRO: '.$centro;
				break;
			case "work":
				$nombre = strtr(strtoupper($timeline[$i]['content']['position']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
				$centro = strtr(strtoupper($timeline[$i]['content']['company']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
				$tipo = $timeline[$i]['content']['type'];
				$certificado = "";
				$titulo_first = '<b>ACTUALMENTE TRABAJO COMO </b> '.$nombre.' EN '.$centro;
				$titulo = $nombre;
				$titulo2 = $centro;
				$place = 'EMPRESA: '.$centro;
				break;
			case "proyect":
				$nombre = strtr(strtoupper($timeline[$i]['content']['title']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
				$centro = "";
				$tipo = "";
				$certificado = "";
				$titulo_first = '<b>ACTUALMENTE DESARROLLO EL PROYECTO </b> '.$nombre;
				$titulo = 'PROYECTO - '.$nombre;
				$titulo2 = $nombre;
				$place = $nombre;
				break;
		}
		//Campos comunes
		$fecha_ini = $timeline[$i]['content']['start_date'];
		$fecha_fin = $timeline[$i]['content']['end_date'];
		$description = html_entity_decode($timeline[$i]['content']['description']);
		
		if ($i == 0) 
			$fondo = "higlight_background_alpha";
		else {
			switch ($timeline[$i]['type']) {
				case "education":
					$fondo = "education_background_alpha";
					break;
				case "work":
					$fondo = "work_background_alpha";
					break;
				case "proyect":
					$fondo = "proyect_background_alpha";
					break;
			}
		}
echo '<div class = "contenedor_elemento">
		<div class = "bar_difuminada '.$fondo.'">
			<div class = "row">
				<div class = "small-12 columns">';
					if ($fecha_ini == '0000-00-00' || $fecha_ini == '' || !isset($fecha_ini))
						$inicio = 'N.I.';
					else
						$inicio = date("Y", strtotime($fecha_ini));
					if ($fecha_fin == '0000-00-00' || $fecha_fin == '')
						$fin = '';
					else
						$fin = ' - '.date("Y", strtotime($fecha_fin));
					if ($i != 0) {
						if ($timeline[$i]['type'] == "education")
							echo '<a><div id = "title'.$i.'" class = "title_education">';
						else if ($timeline[$i]['type'] == "work")
							echo '<a><div id = "title'.$i.'" class = "title_work">';
						else
							echo '<a><div id = "title'.$i.'" class = "title_proyect">';
					} else
						echo '<a><div id = "title'.$i.'" class = "title_actual">';
						echo '<div class = "medium-10 small-12 columns">';
							echo '<div class = "etiqueta_fecha">'.$inicio.$fin.'</div>';
							echo '<div class = "titulo_part1"><h1>'.$titulo.'</h1></div>';
						echo '</div>';
						echo '<div class = "medium-2 small-12 columns tabla">';
							if (isset($_GET['filtro']))
								$arrow = 'down.png';
							else
								$arrow = 'up.png';
							echo '<div class = "centrado arrow"><img id = "replegar'.$i.'" src = "'.$program->getDir().'img/'.$arrow.'" width = "30px"></div>';
						echo '</div>';
						/*echo '<div class = "medium-5 columns">';
						 echo '<div class = "titulo_part2"><h1>'.$titulo2.'</h1></div>';
						echo '</div>';*/
						echo '<div class = "relleno"></div>';
					echo '</div></a>';
				echo '</div>
			</div>
		</div>';
		echo '<div class = "row"><div class = "small-12 columns">';
			echo '<div id = "elem'.$i.'" class = "elemento franja">';
				//DESCRIPCIÓN
				echo '<div class = "descripcion">';
					echo '<div class = "medium-12 columns padding">';
						echo '<h2 class = "'.$estilo.'"><b>'.$place.'</b></h2>';
						echo '<div class = "dos_columnas show-for-medium-up">
							'.$description.'
							<p>Duración: '.$controller->getTime ($fecha_ini, $fecha_fin).'</p>';
							if ($timeline[$i]['type'] == "education") {
								if ($timeline[$i]['content']['end'])
									echo '<b>Terminado</b>';
								else 
									echo '<b>En curso</b>';
							}
							echo '<p>';
							if (isset($timeline[$i]['content']['language'])) {
								$language = $timeline[$i]['content']['language'];
								if (count($language) != 0) {
									for ($l = 0; $l < count($language); $l++) {
										echo '<span class = "label">'.strtr(strtoupper($language[$l]['name']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ").': '.$lan_level[$language[$l]['level']].'</span>&nbsp';
									}	
								}
							}
							echo '</p>';
						echo '</div>';
						echo '<div class = "unacolumna show-for-small">
								<h2 class = "'.$estilo.'"><b>'.$place.'</b></h2>
								'.$description.'
								<p>Duración: '.$controller->getTime ($fecha_ini, $fecha_fin).'</p>';
								if ($timeline[$i]['type'] == "education") {
									if ($timeline[$i]['content']['end'])
										echo '<b>Terminado</b>';
									else 
										echo '<b>En curso</b>';
								}
							echo '<p>';
							if (isset($timeline[$i]['content']['language'])) {
								$language = $timeline[$i]['content']['language'];
								if (count($language) != 0) {
									for ($l = 0; $l < count($language); $l++) {
										echo '<span class = "label">'.strtr(strtoupper($language[$l]['name']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ").': '.$lan_level[$language[$l]['level']].'</span>&nbsp';
									}
								}
							}
							echo '</p>';
						echo '</div>';
						if ($timeline[$i]['type'] == 'education' && isset($timeline[$i]['content']['certificate']) && $timeline[$i]['content']['certificate'] != '')
							echo '<div id = "certificate"><a href = "Data/Users/'.$info['dir'].'/'.$timeline[$i]['content']['certificate'].'" data-lightbox="education'.$i.'"><img src = "'.$program->getDir().'img/certificate.png" width = "30px"></a></div>';
				echo '</div><div class = "relleno"></div></div>';
				//IMÁGENES
				if (isset($timeline[$i]['content']['images'])) {
					$imagenes = $timeline[$i]['content']['images'];
					if (count($imagenes) != 0) {
						$array = $controller->orderImages(count($imagenes));
						echo '<div class = "imagenes">';
						for ($s = 0; $s < count($imagenes); $s++) {
							echo '<a href = "Data/Users/'.$info['dir'].'/'.$imagenes[$s]['file'].'" data-lightbox="project'.$i.'" data-title="'.$imagenes[$s]['name'].'<br><br>'.$imagenes[$s]['description'].'"><div id = "imagen_proyecto'.$imagenes[$s]['id_proyectimg'].'" class = "medium-'.$array[$s].' columns fondo_imagen_proyecto"></div></a>';
							echo '<script>document.getElementById(\'imagen_proyecto'.$imagenes[$s]['id_proyectimg'].'\').style.backgroundImage="url(\'Data/Users/'.$info['dir'].'/'.$imagenes[$s]['file'].'\')";</script>';
						}
						echo '<div class = "relleno"></div>';
						echo '</div>';
					}
				}
				//VIAJES
				if (isset($timeline[$i]['content']['travel'])) {
					echo '<div class = "medium-4 small-3 columns hr_interno"><hr></div><div class = "medium-4 small-6 columns"><h2 class = "text-center title_interno">VIAJES</h2></div><div class = "medium-4 small-3 columns hr_interno"><hr></div><div class = "relleno"></div>';
					echo '<div class = "'.$estilo.'"><hr></div>';
					$travels = $timeline[$i]['content']['travel'];
					foreach ($travels as $k => $v) {
						echo '<div class = "viajes">';
							echo '<div id = "viaje'.$i.$k.'" class = "medium-6 columns fondo_viaje tabla">';
								echo '<div class = "centrado titulo_viaje">';
									echo '<h3>'.strtr(strtoupper($v['location']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ").'</h3>';
								echo '</div>';
							echo '</div>';
							echo '<div class = "medium-6 columns padding">';
								echo '<h2 class = "'.$estilo.'">'.strtr(strtoupper($v['title']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ").'</h2>';
								echo '<small>'.$controller->getDateElement ($v['start_date']).' - '.$controller->getDateElement ($v['end_date']).'</small><br>';
								echo html_entity_decode($v['story']);
								foreach ($viajes[$v['id_travel']]['language'] as $k1 => $v2) {
									echo '<span class = "label">'.$v2['name'].': '.$lan_level[$v2['level']].'</span>&nbsp';
								}
							echo '</div><div class = "relleno"></div>';
						echo '</div>';
						echo '<script>document.getElementById(\'viaje'.$i.$k.'\').style.backgroundImage="url(\'Data/Users/'.$info['dir'].'/'.$v['img'].'\')";</script>';
					}
				}
				//PROYECTOS
				if (isset($timeline[$i]['content']['proyect'])) {
					$proyects = $timeline[$i]['content']['proyect'];
					if (count($proyects) != 0) {
						echo '<div class = "medium-4 small-3 columns hr_interno"><hr></div><div class = "medium-4 small-6 columns"><h2 class = "text-center title_interno">PROYECTOS</h2></div><div class = "medium-4 small-3 columns hr_interno"><hr></div><div class = "relleno"></div>';
						echo '<div class = "proyectos">';
						for ($p = 0; $p < count($proyects); $p++) {
							echo '<a onclick = "open_definition(\'proyect_definition'.$i.$k.'\', \''.$proyects[$p]['id_proyect'].'\')"><div class = "medium-3 small-6 columns proyecto tabla"><div class = "centrado">'.strtr(strtoupper($proyects[$p]['title']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ").'</div></div></a>';
						}
							echo '<div class = "relleno"></div>';
						echo '</div>';
						echo '<div id = "proyect_definition'.$i.$k.'" class = "definicion oculto"></div>';
					}
				}
				//APTITUDES
				if (isset($timeline[$i]['content']['skill'])) {
					$skills = $timeline[$i]['content']['skill'];
					if (count($skills) != 0) {
						echo '<div class = "'.$estilo.'"><hr></div>';
						echo '<p>Durante esta experiencia he desarrollado las siguientes aptitudes:</p>';
						echo '<div class = "aptitudes">';
						for ($s = 0; $s < count($skills); $s++) {
							echo '<div class = "medium-3 small-6 columns">';
								echo '<div class = "small-12 columns idioma_sub tabla"><div class = "centrado">'.strtr(strtoupper($skills[$s]['name']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ").'</div></div>';
								echo '<div class = "small-12 columns level">'.$apt_level[$skills[$s]['level']].'</div>';
							echo '</div>';
						}
							echo '<div class = "relleno"></div>';
						echo '</div>';
						
					}
				}
			echo '</div>';
		echo '</div>';
		echo '<div class = "small-12 columns transicion"></div>';
echo'</div></div>';
		if (!isset($_GET['filtro'])) {
			if ($settings['travel']) {
				//MAPA
				if ($i == $pos_map) {
					
					echo '<div class = "bar_mapa"><div class = "row"><div class = "small-12 columns">';
						echo '<div class = "title_maps">';
							echo '<h2>MIS VIAJES POR EL MUNDO</h2>';
						echo '</div>';
					echo '</div></div></div>';
					echo '<div class = "row"><div class = "small-12 columns"><div id="googleMap"></div></div></div>';
				}
			}
			if ($settings['language']) {
				if (count($idiomas) > 0) {
					//IDIOMAS
					if ($i == $pos_languages) {
						echo '<div class = "small-12 columns">';
							echo '<div class = "title_act">';
								echo '<h2>IDIOMAS</h2>';
							echo '</div>';
						echo '</div>';
						
						echo '<div class = "background_module"><div class = "row"><div id = "idiomas" class = "small-12 columns">';
							echo '<div class = "medium-3 small-6 columns">';
								echo '<div class = "small-12 columns idioma tabla higlight_background"><div class = "centrado">'.strtr(strtoupper($info['native_language']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ").'</div></div>';
								echo '<div class = "small-12 columns level">NATIVO</div>';
							echo '</div>';
							foreach ($idiomas as $k => $v) {
								echo '<div class = "medium-3 small-6 columns">';
									echo '<div class = "small-12 columns idioma tabla"><div class = "centrado">'.strtr(strtoupper($v['name']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ").'</div></div>';
									echo '<div class = "small-12 columns level">'.$lan_level[$v['level']].'</div>';
								echo '</div>';
							}
						echo '</div><div class = "relleno"></div></div></div>';
					}
				}
			}
			if ($settings['skill']) {
				if (count($aptitudes) > 0) {
					//APTITUDES
					if ($i == $pos_skills) {
						echo '<div class = "small-12 columns">';
							echo '<div class = "title_act">';
								echo '<h2>APTITUDES</h2>';
							echo '</div>';
						echo '</div>';
						echo '<div class = "background_module"><div class = "row"><div id = "idiomas" class = "small-12 columns">';
							foreach ($aptitudes as $k => $v) {
								echo '<div class = "medium-3 small-6 columns">';
									echo '<div class = "small-12 columns idioma tabla"><div class = "centrado">'.strtr(strtoupper($v['name']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ").'</div></div>';
									echo '<div class = "small-12 columns level">'.$apt_level[$v['level']].'</div>';
								echo '</div>';
							}
						echo '</div><div class = "relleno"></div></div></div>';
					}
				}
			}
			if ($settings['activity']) {
				//ACTIVIDADES
				if ($i == $pos_activities) {
					if (count($activities) > 0) {
						echo '<div id = "activities" class = "show-for-medium-up">';
								echo '<div class = "title_act">';
									echo '<h2>ACTIVIDADES</h2>';
								echo '</div>';
							echo '</div>';
							$activities = $controller->activityLevels();
							$max = max($activities);
							$mountains_red = array("vacio.png","04.png","03.png","02.png","01.png");
							$mountains = array("vacio.png","04_gris.png","03_gris.png","02_gris.png","01_gris.png");
							if ($max > 0) {
								/*echo '<div class = "small-12 columns titulitos"><h2 class = "highlight">ACTIVIDADES</h2></div>';*/
								$activities_img = array();
								foreach ($activities as $k => $v) {
									if ($v == $max)
										$activities_img[$k] = $mountains_red[$v];
									else
										$activities_img[$k] = $mountains[$v];
								}
								echo '<div class = "row"><div class = "small-12 columns">';
									echo '<div class = "act-1"><div class = "small-12 columns"><img src = "'.$program->getDir().'img/'.$activities_img['evento'].'" width = "100%"></div><div class = "small-12 columns text-center"><br><b>EVENTOS</b></div></div>';
									echo '<div class = "act-2"><div class = "small-12 columns"><img src = "'.$program->getDir().'img/'.$activities_img['voluntariado'].'" width = "100%"></div><div class = "small-12 columns text-center"><br><b>VOLUNTARIADO</b></div></div>';
									echo '<div class = "act-3"><div class = "small-12 columns"><img src = "'.$program->getDir().'img/'.$activities_img['hablar'].'" width = "100%"></div><div class = "small-12 columns text-center"><br><b>HABLAR EN PÚBLICO</b></div></div>';
									echo '<div class = "act-4"><div class = "small-12 columns"><img src = "'.$program->getDir().'img/'.$activities_img['emprender'].'" width = "100%"></div><div class = "small-12 columns text-center"><br><b>EMPRENDEDIMIENTO</b></div></div>';
								echo '</div></div>';
								/*echo '<div class = "small-12 columns leyenda_actividades">';
									echo '<div class = "medium-6 columns">1.- <b>Eventos</b> a los que acudo.</div>';
									echo '<div class = "medium-6 columns">2.- <b>Actividades voluntarias</b> que realizo.</div>';
									echo '<div class = "medium-6 columns">3.- <b>Charlas, conferencias o presentaciones</b> que hago.</div>';
									echo '<div class = "medium-6 columns">4.- Actos relacionados con el <b>emprendimiento</b>.</div>';
								echo '</div>';*/
							}
							echo '<div class = "relleno"></div>';
						echo '</div></div></div>';
					}
				}
			}
		}
	}
	if (!isset($_GET['filtro'])) {
		echo '<div class = "show-for-medium-up">';
			if ($settings['mtlsport']) {
				//DEPORTE
				if (count($deporte) > 0) {
					echo '<div class = "small-12 columns">';
						echo '<div class = "title_act">';
							echo '<h2>NIVEL DEPORTIVO</h2>';
						echo '</div>';
					echo '</div>';
					echo '<div class = "row"><div id = "deporte" class = "small-12 columns">';
						/*echo '<div class = "small-12 columns titulitos"><h2 class = "highlight">NIVEL DEPORTIVO</h2></div>';*/
						$sport_levels = array("deporte01_txt.png", "deporte01_txt.png", "deporte02_txt.png", "deporte03_txt.png");
						$level_sport = $controller->levelDeporte($deporte);
						echo '<div class = "small-12 columns">';
							echo '<div class = "deportes">';
								echo '<img title = "Nivel deportivo" src = "'.$program->getDir().'img/'.$sport_levels[$level_sport].'" width = "100%" alt = "Nivel deportivo">';
								foreach ($deporte as $k => $v) {
									echo '<a><div class = "small-3 columns deporte tabla"><div class = "centrado">'.strtr(strtoupper($v['category']),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ").'</div></div></a>';
								}
							echo '</div>';
						echo '</div>';
					echo '</div></div>';
				}
			}
			if ($settings['mtlculture']) {
				//CULTURA
				if (count($cultura) > 0) {
					echo '<div class = "small-12 columns">';
						echo '<div class = "title_act">';
							echo '<h2>INTERESES CULTURALES</h2>';
						echo '</div>';
					echo '</div>';
					/*echo '<div class = "small-12 columns titulitos"><h2 class = "highlight">INTERESES CULTURALES</h2></div>';*/
					echo '<div class = "row"><div id = "cultura" class = "small-12 columns">';
						/*echo '<div class = "elemento">';*/
							echo '<div class = "interests">';
								foreach ($cultura as $k => $v) {
									echo '<div class = "medium-3 small-6 columns">';
									if (isset($v['img']) && $v['img'] != '') {
											echo '<a href = "Data/Users/'.$info['dir'].'/'.$v['img'].'" data-lightbox="aficion'.$k.'" data-title="'.$v['title'].'"><div id = "culture'.$k.'" onmouseover = "mostrarCapa(\'txt_culture'.$k.'\')" onmouseleave = "ocultarCapa(\'txt_culture'.$k.'\')" class = "small-12 columns cultura"><div id = "txt_culture'.$k.'" class = "txt_culture tabla oculto"><div class = "centrado">'.strtr(strtoupper($v['category']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ").'<br>'.$v['title'].'</div></div></div></a>
										</div>';
										echo '<script>document.getElementById(\'culture'.$k.'\').style.backgroundImage="url(\'Data/Users/'.$info['dir'].'/'.$v['img'].'\')";</script>';
									} else {
										echo '<div id = "txt_culture'.$k.'" class = "txt_culture fondo_general tabla"><div class = "centrado">'.strtr(strtoupper($v['category']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ").'<br>'.$v['title'].'</div></div>
										</div>';
									}
								}
								echo '<div class = "relleno"></div>';
							echo '</div>';
						/*echo '</div>';*/
					echo '</div></div>';
				}
			}
			if ($settings['mtlart']) {
				//AFICIONES
				if (count($aficiones) > 0) {
					echo '<div class = "small-12 columns">';
						echo '<div class = "title_act">';
							echo '<h2>AFICIONES</h2>';
						echo '</div>';
					echo '</div>';
					echo '<div class = "row"><div id = "aficiones" class = "small-12 columns">';
						/*echo '<div class = "small-12 columns titulitos"><h2 class = "highlight">AFICIONES</h2></div>';*/
						echo '<div class = "small-12 columns">';
							/*echo '<div class = "elemento">';*/
								echo '<div class = "aficiones">';
									$array = $controller->orderImages(count($aficiones));
									$counter = 0;
									foreach ($aficiones as $k => $v) {
										echo '<div class = "medium-3 small-12 columns">';
										if (isset($v['img']) && $v['img'] != '') {
													echo '<a href = "Data/Users/'.$info['dir'].'/'.$v['img'].'" data-lightbox="aficion'.$k.'" data-title="'.$v['title'].'"><div id = "aficion'.$k.'" onmouseover = "mostrarCapa(\'txt_aficion'.$k.'\')" onmouseleave = "ocultarCapa(\'txt_aficion'.$k.'\')" class = "small-12 columns aficion"><div id = "txt_aficion'.$k.'" class = "txt_aficion tabla oculto"><div class = "centrado">'.strtr(strtoupper($v['category']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ").'<br>'.$v['title'].'</div></div></div></a>
												</div>';
											echo '<script>document.getElementById(\'aficion'.$k.'\').style.backgroundImage="url(\'Data/Users/'.$info['dir'].'/'.$v['img'].'\')";</script>';
										} else {
											echo '<div id = "txt_aficion'.$k.'" class = "txt_aficion fondo_general tabla"><div class = "centrado">'.strtr(strtoupper($v['category']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ").'<br>'.$v['title'].'</div></div>
											</div>';
										}
											$counter++;
									}
									echo '<div class = "relleno"></div>';
								echo '</div>';
							/*echo '</div>';*/
						echo '</div>';
					echo '</div></div>';
				}
			}
			if ($settings['objetives']) {
				//PRÓXIMOS OBJETIVOS
				if (isset($upgrade['obj1']) && $upgrade['obj1'] != '' && isset($upgrade['obj2']) && $upgrade['obj2'] != '' && isset($upgrade['obj3']) && $upgrade['obj3'] != '') {
					echo '<div class = "small-12 columns">';
						echo '<div class = "title_act">';
							echo '<h2>PRÓXIMOS OBJETIVOS</h2>';
						echo '</div>';
					echo '</div>';
					echo '<div class = "row"><div class = "small-12 columns objetivos">';
						echo '<div class = "small-12 columns">';
							echo '<img title = "Próximos objetivos" src = "'.$program->getDir().'img/objetivos2.png" width = "100%" alt = "objetivos laborales">';
						echo '</div>';
						echo '<div class = "small-12 columns lista_objetivos">';
							echo '<div class = "small-4 columns">1º- '.$upgrade['obj1'].'</div>';
							echo '<div class = "small-4 columns">2º- '.$upgrade['obj2'].'</div>';
							echo '<div class = "small-4 columns">3º- '.$upgrade['obj3'].'</div>';
						echo '</div>';
						echo '<div clas = "relleno"></div>';
					echo '</div></div><hr>';
				}
			}
		echo '</div>';
		//FOCO
		echo '<div class = "row"><div class = "small-12 columns">';
			echo '<div class = "fin">';
				if (isset($upgrade['focus']) && $upgrade['focus'] != '')
					echo '<h2>Mi foco está en '.$upgrade['focus'].'</h2>';
				if (isset($upgrade['end']) && $upgrade['end'] != '')
					echo '<p>"'.$upgrade['end'].'"</p>';
				echo '<br><b>Continuará...</b>';
			echo '</div>';
		echo '</div></div>';
	}
	?>