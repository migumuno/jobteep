<?php
	setlocale(LC_CTYPE,"es_ES");
	$controller = $_SESSION['SO']->getController();
	$info = $controller->getUserInfo();
	$UID = $info['id_user'];
	$controller->setUID ($UID);
	$controller->setUser ($info['user']);
	$controller->setVersion ($info['version']);
	$settings = $controller->getSettings ();
	$upgrade = $controller->getUpgrade ();
	$template = $controller->getTemplateInfo ($UID, $info['template']);
	$gamas = array("jobteep", "happy", "business", "beachday");
	$gama = $gamas[$template['gama']];
	
	//Obtención de elementos
	$viajes = $controller->viajes();
	$activities = $controller->activityLevels();
	$aptitudes = $controller->aptitudes();
	$idiomas = $controller->idiomas();
	$cultura = $controller->cultura();
	$aficiones = $controller->aficiones();
	$deporte = $controller->deporte();
	$trabajos = $controller->trabajos();
	$formacion = $controller->formacion();
	$proyectos = $controller->proyectos();
	$controller->saveProyects ($proyectos);
	$proyectos_independientes = $controller->proyectos(false);
	$timeline = array();
	if (isset($_GET['filtro']) && $_GET['filtro'] == 'formacion') {
		for ($i = 0; $i < count($formacion); $i++) {
			$timeline[] = array(
					"type" => "education",
					"content" => $formacion[$i]
			);
		}
	} else if (isset($_GET['filtro']) && $_GET['filtro'] == 'trabajo') {
		for ($i = 0; $i < count($trabajos); $i++) {
			$timeline[] = array(
					"type" => "work",
					"content" => $trabajos[$i]
			);
		}
	} else if (isset($_GET['filtro']) && $_GET['filtro'] == 'proyectos') {
		for ($i = 0; $i < count($proyectos); $i++) {
			$timeline[] = array(
					"type" => "proyect",
					"content" => $proyectos[$i]
			);
		}
	} else
		$timeline = $controller->timeline ($formacion, $trabajos, $proyectos_independientes);
?>
<!doctype html>
<html class="no-js" lang="es">
<head>
	<meta charset="utf-8" />
    <title><?php echo $info['name'].' '.$info['surname']; ?></title>
    <base href="http://www.jobteep.com/">
    <meta name="description" content="<?php echo $program->getInfo('description'); ?>">
	<meta name="keywords" content="<?php echo $program->getInfo('keywords'); ?>">
	<meta name="author" content="<?php echo $info['name'].' '.$info['surname'] ?>">
	<link rel="shortcut icon" href="<?php echo $program->getDir() ?>img/favicon.ico">
	<link rel="icon" href="<?php echo $program->getDir() ?>img/favicon.png">
	<link rel="apple-touch-icon-precomposed" href="<?php echo $program->getDir() ?>img/apple.png">
	<meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <link rel="canonical" href="http://www.jobteep.com/<?php echo $_GET['domain'] ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="Libraries/foundation/css/foundation.css" />
    <link rel="stylesheet" href="<?php echo $program->getDir(); ?>css/app.css" />
    <link rel="stylesheet" href="<?php echo $program->getDir(); ?>css/<?php echo $gama ?>.css" />
    <script src="Libraries/foundation/js/vendor/modernizr.js"></script>
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
    <link type="text/css" href="Libraries/skitter_slider/css/skitter.styles.css" media="all" rel="stylesheet" />
	<script type="text/javascript" src="Libraries/skitter_slider/js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="Libraries/skitter_slider/js/jquery.skitter.min.js"></script>
	<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBvb5rGbk9ELMY_XYKViUIW-QyKnJluvu0&sensor=false"></script>
	<!-- LIGHTBOX -->
	<script src="Libraries/lightbox/js/lightbox.min.js"></script>
	<link href="Libraries/lightbox/css/lightbox.css" rel="stylesheet" />
	
	<script>
		$(document).ready(function () {
			<?php if (isset($_GET['filtro']))
				echo '$( ".franja" ).hide();';?>
			$( ".oculto" ).hide();
			/*$(".cultura").skitter();*/
			$( "#ocultar_destacados" ).click( function (){
				$( "#capa_destacados" ).slideUp( "slow", function() {
					$( "#contenido_destacados" ).html( "" );
				});
			});
			<?php
			for ($i = 0; $i < count($timeline); $i++) {
				echo '
				$( "#title'.$i.'" ).click( function () {
					$( "#elem'.$i.'" ).slideToggle( "slow", function() {
						var replegar = $( "#replegar'.$i.'" );
						switch (replegar.attr("src")) {
							case "'.$program->getDir().'img/down.png":
								replegar.attr("src", "'.$program->getDir().'img/up.png");
								break;
							case "'.$program->getDir().'img/up.png":
								replegar.attr("src", "'.$program->getDir().'img/down.png");
								break;
						}
					});
				});
				';
			}
			if (isset($template['header_img']) && $template['header_img'] != '')
				echo '$( "#cabecera" ).css("background-image", "url(\'Data/Users/'.$info['dir'].'/'.$template['header_img'].'\')");';
			else {
				echo '
				var styles = {
			      background : "none",
			      float: "none"
			    };
				var pdf = {
				  background : "none",
				  position: "relative",
				  left: "50%",
				  marginLeft: "-100px"
				};
				';
				echo '$( "#cabecera" ).find( "h1" ).css( styles );';
				echo '$( "#cabecera" ).find( "h3" ).css( styles );';
				echo '$( "#cabecera" ).find( "h4" ).css( pdf );';
			}
			
			if (isset($template['imgD1']) && $template['imgD1'] != '')
				echo '$( "#destacado1" ).css("background-image", "url(\'Data/Users/'.$info['dir'].'/'.$template['imgD1'].'\')");';
			if (isset($template['imgD2']) && $template['imgD2'] != '')
				echo '$( "#destacado2" ).css("background-image", "url(\'Data/Users/'.$info['dir'].'/'.$template['imgD2'].'\')");';
			if (isset($template['imgD3']) && $template['imgD3'] != '')
				echo '$( "#destacado3" ).css("background-image", "url(\'Data/Users/'.$info['dir'].'/'.$template['imgD3'].'\')");';
			?>
		});
	</script>
	<script>
		function mostrar_destacado(txt) {
			$( "#capa_destacados" ).slideUp( "slow", function() {
				$( "#contenido_destacados" ).html( txt );
			});
			$( "#capa_destacados" ).slideDown( "slow" );
		}

		function showSlider (img, name, description) {
			$( "#slider" ).slideDown( "slow" );
			$( "#contenido_slider" ).html("<h1>"+ name +"</h1>");
			$( "#contenido_slider" ).append("<img src = \"Data/Users/<?php echo $info['dir'] ?>/"+img+"\">");
		}

		function mostrarCapa (div) {
			$( "#" + div ).fadeIn( "slow" );
		}

		function ocultarCapa (div) {
			$( "#" + div ).fadeOut( "slow" );
		}

		function open_definition(div, id) {
			$( "#" + div ).load("consultas.php", {id_proyect: id, action: "proyect", dir: "<?php echo $program->getDir(); ?>", dirname: "<?php echo $info['dir'] ?>", program: "profile"});
			$( "#" + div ).slideToggle( "slow" );
		}

		function close_definition(div) {
			$( "#" + div ).slideUp( "slow" );
		}
	</script>
	<script>
		function initialize() {
			var mapProp = {
			  center:new google.maps.LatLng(34.2556617,5.992691),
			  zoom:2,
			  mapTypeId:google.maps.MapTypeId.TERRAIN
			  };
	
			var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
	
			/*Marcadores*/
			<?php
			if($info['city'] != '' && !is_null($info['city'])) {
				$controller->printMarker ($info['city'], 'Donde vivo', 4, '0000-00-00', '0000-00-00');
			}
			foreach ($viajes as $k => $v) {
				$controller->printMarker ($v['location'], $v['title'].' en '.$v['location'], $v['type'], $v['start_date'], $v['end_date']);
			}
			?>
		}
		
		google.maps.event.addDomListener(window, 'load', initialize);
	</script>
</head>
<body>
<div itemscope itemtype="http://schema.org/Person">
	<!-- <div id = "slider" class = "oculto">
		<a onclick = "$('#slider').slideUp('slow');"><img class = "close_cross" src = "<?php /*echo $program->getDir()*/ ?>img/close.png" width = "30px"></a>
		<div class = "row">
			<div class = "small-12 columns">
				<div id = "contenido_slider">
					
				</div>
			</div>
		</div>
	</div> -->
	<div class = "row">
		<div class = "medium-12 columns">
			<div id = "barra_superior">
				<div class = "small-6 columns">
					<div id = "buscando">
						<?php $buscando = array("Nada", "Prácticas", "Beca", "Formación", "Primer empleo", "Trabajo", "Voluntariado", "Inversión", "Apoyo") ?>
						BUSCO: <?php echo strtr(strtoupper($buscando[$info['lookingfor']]), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ") ?>
					</div>
				</div>
				<div class = "small-6 columns">
					<div id = "contacto">
						<ul>
							<?php if (isset($info['linkedin']) && $info['linkedin'] != '') echo '<li class = "border_li_right"><a href = "'.$info['linkedin'].'" target = "_blank"><img src = "'.$program->getDir().'img/linkedin.png" alt = "linkedin" width = "20px"></a></li>'; ?>
							<?php if (isset($info['facebook']) && $info['facebook'] != '') echo '<li class = "border_li_right"><a href = "'.$info['linkedin'].'" target = "_blank"><img src = "'.$program->getDir().'img/facebook.png" alt = "facebook" width = "20px"></a></li>'; ?>
							<?php if (isset($info['twitter']) && $info['twitter'] != '') echo '<li class = "border_li_right"><a href = "'.$info['linkedin'].'" target = "_blank"><img src = "'.$program->getDir().'img/twitter.png" alt = "twitter" width = "20px"></a></li>'; ?>
							<?php if (isset($info['web']) && $info['web'] != '') echo '<li class = "border_li_right"><a href = "'.$info['linkedin'].'" target = "_blank"><img src = "'.$program->getDir().'img/web.png" alt = "web" width = "20px"></a></li>'; ?>
							<?php if (isset($info['email']) && $info['email'] != '') echo '<li class = "border_li_right"><a href = "mailto:'.$info['email'].'"><img title = "'.$info['email'].'" src = "'.$program->getDir().'img/mail.png" alt = "web" width = "20px"></a></li>'; ?>
							<?php if (isset($info['telf1']) && $info['telf1'] != '') echo '<li><a href = "tel:'.$info['telf1'].'"><img title = "'.$info['telf1'].'" src = "'.$program->getDir().'img/telf.png" alt = "web" width = "20px"></a></li>'; ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class = "medium-12 columns">
			<div id = "cabecera" class = "tabla">
				<div class = "centrado">
					<h1 class = "negro"><a href = "http://www.jobteep.com/<?php echo $_GET['domain'] ?>" itemprop="url">Soy <span itemprop="name"><?php echo $info['name'].' '.$info['surname'] ?></span></a></h1>
					<h3><span itemprop="jobTitle"><?php echo $info['profession']; ?></span></h3>
					<a href = "http://www.jobteep.com/<?php echo $_GET['domain'] ?>/PDF" target = "_blank"><h4>CURRICULUM STANDARD.PDF</h4></a>
				</div>
			</div>
		</div>
		<div class = "medium-12 columns">
			<div id = "slogan" class = "tabla">
				<div class = "centrado">
					<h3>"<?php echo $info['slogan']; ?>"</h3>
				</div>
			</div>
		</div>
		<div class = "medium-12 columns show-for-medium-up">
			<div id = "destacados">
				<div class = "medium-3 columns">
					<div id = "destacado1" class = "tabla">
						<div class = "centrado">
							<?php 
							if (isset($template['txtD1']) && $template['txtD1'] != '')
								echo '<h3>'.strtr(strtoupper($template['txtD1']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ").'</h3>';
							?>
						</div>
					</div>
				</div>
				<div class = "medium-3 columns">
					<div id = "destacado2" class = "tabla">
						<div class = "centrado">
							<?php 
							if (isset($template['txtD2']) && $template['txtD2'] != '')
								echo '<h3>'.strtr(strtoupper($template['txtD2']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ").'</h3>'
							?>
						</div>
					</div>
				</div>
				<div class = "medium-6 columns">
					<div id = "destacado3" <?php if ($template['typeD3'] == 0) echo 'class = "tabla"' ?>>
						<?php if ($template['typeD3'] == 0) echo '<div class = "centrado">' ?>
							<?php 
							if ($template['typeD3'] == 0 && isset($template['txtD3']) && $template['txtD3'] != '') {
								echo '<h3>'.strtr(strtoupper($template['txtD3']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ").'</h3>';
							} else if ($template['typeD3'] == 1) {
								echo '<iframe width="100%" height="100%" src="https://www.youtube.com/embed/'.$template['videoD3'].'?showinfo=0&controls=0" frameborder="0" allowfullscreen></iframe>';
							}
							?>
						<?php if ($template['typeD3'] == 0) echo '</div>' ?>
					</div>
				</div>
			</div>
		</div>
		<div class = "small-12 columns quiensoy">
			<?php echo html_entity_decode($info['description']) ?>
		</div>
		<?php
		$contador = 0; 
		if (count($formacion) > 0)
			$contador++;
		if (count($trabajos) > 0)
			$contador++;
		if (count($proyectos) > 0)
			$contador++;
		if ($contador == 0)
			$tam = 12;
		else if ($contador == 1)
			$tam = 6;
		else if ($contador == 2)
			$tam = 4;
		else if ($contador == 3)
			$tam = 3;
		?>
		<div class = "medium-12 columns show-for-medium-up menu">
			<div class = "medium-<?php echo $tam ?> higlight_background menu_element columns<?php if (!isset($_GET['filtro'])) echo ' menu_selected' ?>"><a href = "http://www.jobteep.com/<?php echo $_GET['domain'] ?>#enlace"><h1>MI HISTORIA</h1></a></div>
			<?php if (count($formacion) > 0) { ?><div class = "medium-<?php echo $tam ?> education_background menu_element columns<?php if (isset($_GET['filtro']) && $_GET['filtro'] == 'formacion') echo ' menu_selected' ?>"><a href = "http://www.jobteep.com/<?php echo $_GET['domain'] ?>/formacion#enlace"><h1>FORMACIÓN</h1></a></div><?php } ?>
			<?php if (count($trabajos) > 0) { ?><div class = "medium-<?php echo $tam ?> work_background menu_element columns<?php if (isset($_GET['filtro']) && $_GET['filtro'] == 'trabajo') echo ' menu_selected' ?>"><a href = "http://www.jobteep.com/<?php echo $_GET['domain'] ?>/trabajo#enlace"><h1>TRABAJO</h1></a></div><?php } ?>
			<?php if (count($proyectos) > 0) { ?><div class = "medium-<?php echo $tam ?> proyect_background menu_element columns<?php if (isset($_GET['filtro']) && $_GET['filtro'] == 'proyectos') echo ' menu_selected' ?>"><a href = "http://www.jobteep.com/<?php echo $_GET['domain'] ?>/proyectos#enlace"><h1>PROYECTOS</h1></a></div><?php } ?>
		</div>
		<div class = "medium-12 columns show-for-small menu">
			<div class = "small-<?php echo $tam ?> higlight_background menu_element columns<?php if (!isset($_GET['filtro'])) echo ' menu_selected' ?>"><a href = "http://www.jobteep.com/<?php echo $_GET['domain'] ?>#enlace"><h1>H</h1></a></div>
			<?php if (count($formacion) > 0) { ?><div class = "small-<?php echo $tam ?> education_background menu_element columns<?php if (isset($_GET['filtro']) && $_GET['filtro'] == 'formacion') echo ' menu_selected' ?>"><a href = "http://www.jobteep.com/<?php echo $_GET['domain'] ?>/formacion#enlace"><h1>F</h1></a></div><?php } ?>
			<?php if (count($trabajos) > 0) { ?><div class = "small-<?php echo $tam ?> work_background menu_element columns<?php if (isset($_GET['filtro']) && $_GET['filtro'] == 'trabajo') echo ' menu_selected' ?>"><a href = "http://www.jobteep.com/<?php echo $_GET['domain'] ?>/trabajo#enlace"><h1>T</h1></a></div><?php } ?>
			<?php if (count($proyectos) > 0) { ?><div class = "small-<?php echo $tam ?> proyect_background menu_element columns<?php if (isset($_GET['filtro']) && $_GET['filtro'] == 'proyectos') echo ' menu_selected' ?>"><a href = "http://www.jobteep.com/<?php echo $_GET['domain'] ?>/proyectos#enlace"><h1>P</h1></a></div><?php } ?>
		</div>
	</div>
	
	<div id = "contenido">
		<?php include $program->getDir() . $program->getInfo('content'); ?>
	</div>
	<div class = "pie">
		<div class = "medium-6 small-12 columns pie_txt">
			<?php 
			echo $info['name'].' '.$info['surname'].'<br>';
			/*<img alt = "email '.$info['name'].' '.$info['surname'].'" src = "Libraries/ImgGenerator/txt.php?txt='.$info['email'].'>*/
			if (isset($info['email']) && $info['email'] != '')
				echo 'EMAIL: <a href = "mailto:'.$info['email'].'" itemprop="email">'.$info['email'].'</a><br>';
			if (isset($info['telf1']) && $info['telf1'] != '')
				echo 'TELF.: '.$info['telf1'];
			?>
			<p><a href = "http://www.jobteep.com/main.php" target = "_blank">&copy;Jobteep | Todos los derechos reservados</a></p>
		</div>
		<div class = "medium-6 small-12 columns pie_img"><img src = "<?php echo $program->getDir() ?>img/pilares.png" width = "100%"></div>
		<div class = "relleno"></div>
	</div>
</div>
	<script src="Libraries/foundation/js/vendor/fastclick.js"></script>
    <script src="Libraries/foundation/js/foundation.min.js"></script>
  	<script src="Libraries/foundation/js/foundation/foundation.equalizer.js"></script>
    <script>
    	$(document).foundation('equalizer', 'reflow');
    	$(document).foundation('clearing', 'reflow');
    </script>
    <script>
	    window.setTimeout(function(){
	        if(window.location.hash){
	            var $target  = $(window.location.hash).closest("#enlace");
	            if($target.length)
	                $('html, body').animate({scrollTop: $target.offset().top}, 1000);
	        }
	    }, 100);
    </script>
</body>
</html>