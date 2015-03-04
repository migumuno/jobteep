<?php 
include_once 'Libraries/ckfinder/ckfinder.php';
$controller = $_SESSION['SO']->getController();
$controller->setEnum('settings');
$collection = $controller->selectAllElements();
$settings_array = $collection->getArray();
foreach ($settings_array as $k => $v) {
	$settings = $v;
}
$background =  $settings->get('background');
$controller->setEnum('info');
$collection = $controller->selectAllElements();
$info_array = $collection->getArray();
foreach ($info_array as $k => $v) {
	$info = $v;
}
unset($controller);
?>
<!doctype html>
<html class="no-js" lang="es">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $program->getInfo('title'); ?></title>
    <meta name="description" content="<?php echo $program->getInfo('description'); ?>">
	<meta name="keywords" content="<?php echo $program->getInfo('keywords'); ?>">
	<meta name="author" content="Miguel Ángel Muñoz Viejo">
	<link rel="shortcut icon" href="<?php echo $program->getDir() ?>img/favicon.ico">
	<link rel="icon" href="<?php echo $program->getDir() ?>img/favicon.png">
	<link rel="apple-touch-icon-precomposed" href="<?php echo $program->getDir() ?>img/apple.png">
	<link href="<?php echo $program->getDir(); ?>img/logo.jpg" rel="image_src">
    <link rel="stylesheet" href="Libraries/foundation/css/foundation.css" />
    <link rel="stylesheet" href="Libraries/foundation/css/normalize.css" />
    <link rel="stylesheet" href="<?php echo $program->getDir(); ?>css/app.css" />
    <link href="http://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
    <script src="Libraries/foundation/js/vendor/modernizr.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="Libraries/jquery-ui/jquery-ui.css " />
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
	<script type="text/javascript" src="Libraries/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="Libraries/ckfinder/ckfinder.js"></script>
	<script type="text/javascript" src="<?php echo $program->getDir(); ?>js/panel.js"></script>
	<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBvb5rGbk9ELMY_XYKViUIW-QyKnJluvu0&sensor=false"></script>
	<!-- Jquery File Upload -->
	<link rel="stylesheet" href="Libraries/jQuery-File-Upload-master/css/style.css">
	<script>
	function openMenu () {
		$('.off-canvas-wrap').foundation('offcanvas', 'show', 'move-right');
	}
	function closeMenu () {
		$('.off-canvas-wrap').foundation('offcanvas', 'hide', 'move-right');
	}
	$(document).ready(function () {
		$( "#recorrido" ).click(function() {
			<?php 
			if (!isset($_GET['menu']) || $_GET['menu'] == 'welcome')
				echo '$("#recorrido_content").foundation(\'joyride\', \'start\');';
			else if ($_GET['menu'] == 'info')
				echo '$("#recorrido_info").foundation(\'joyride\', \'start\');';
			else if ($_GET['menu'] == 'new_experience')
				echo '$("#recorrido_exp").foundation(\'joyride\', \'start\');';
			else if ($_GET['menu'] == 'new_education')
				echo '$("#recorrido_edu").foundation(\'joyride\', \'start\');';
			else if ($_GET['menu'] == 'new_skill')
				echo '$("#recorrido_apt").foundation(\'joyride\', \'start\');';
			else if ($_GET['menu'] == 'new_proyect')
				echo '$("#recorrido_proy").foundation(\'joyride\', \'start\');';
			?>
			
		});
		
		<?php
		if (isset($background) && $background != '')
			echo '$("body").css(\'background-image\', \'url("Data/Users/'.$_SESSION['SO']->getUserInfo ('dir').'/'.$background.'")\');';
		if (SO::$ALERT) {
			echo '
			$( "#msg" ).html(\'<div class = "small-10 small-offset-1 columns">\');
			$( "#msg" ).append(\'<div class = "row"><h4>'.SO::$MESSAGE.'</h4></div>\');
			$( "#msg" ).append(\'<div class = "large-4 large-offset-4 medium-6 medium-offset-3 small-10 small-offset-1 columns text-center"><a id = "close_msg" href = "#"><img src = "'.$program->getDir().'img/bar-iPhone.png"></a></div>\');
			$( "#msg" ).append(\'</div>\');
			$( "#msg" ).fadeIn( "slow");
			$( "#close_msg" ).click(function() {
			  $( "#msg" ).fadeOut( "slow", function() {
				  $( "#msg" ).html(\'\');
				  $( "#msg" ).append(\'<img src = "'.$program->getDir().'img/bar-iPhone.png">\');
			  });
			});
			';
		}
		if (isset($_GET['action']) && $_GET['action'] == 'intro') {
			echo '$("#recorrido_content").foundation(\'joyride\', \'start\');';
		}
		
		/*if (isset($_GET['action']) && $_GET['action'] == 'intro') {
			echo '
			$( "#msg" ).html(\'<div class = "small-10 small-offset-1 columns">\');
			$( "#msg" ).append(\'<div class = "row"><h4>Bienvenido a jobteep!</h4></div>\');
			$( "#msg" ).append(\'<div class = "row text-center"><small>Para cerrar estos diálogos puedes pinchar en la flecha de debajo.</small></div><br>\');
			$( "#msg" ).append(\'</div>\');
			$( "#msg" ).fadeIn( "slow");
			$( "#msg" ).click(function() {
			  $( "#msg" ).fadeOut( "slow", function() {
				  $( "#msg" ).html(\'\');
			  });
			});
			';
		}*/
		?>
		$( "#shareLinks" ).fadeOut();
		$( "#shareButton" ).click(function() {
		  $( "#shareLinks" ).fadeToggle( "slow" );
		});
		var fecha = new Date();
		var anno = fecha.getFullYear() + 1;
		var height = $( window ).height() - 185;
		$(".main-section").css('min-height', height);
		$("#dp1").datepicker({
			dateFormat: 'yy/mm/dd',
			changeYear: true,
			yearRange: "1900:"+anno,
			changeMonth: true
		});
		$("#dp2").datepicker({
			dateFormat: 'yy/mm/dd',
			changeYear: true,
			yearRange: "1900:"+anno,
			changeMonth: true
		});
		$("#birthday").datepicker({
			dateFormat: 'yy/mm/dd',
			changeYear: true,
			yearRange: "1900:"+anno,
			changeMonth: true
		});
		$('#domain').change(function(){
			
	        $('#domain_error').html('<img src="Programs/Web/img/loader.gif" alt="" width = "20px" />').fadeOut(1000);
	
	        var domain = $(this).val();
	
	        $.ajax({
	            type: "POST",
	            url: "ajaxRequests.php",
	            data: {domain: domain, action : 'domain'},
	            success: function(data) {
	                $('#domain_error').fadeIn(1).html(data);
	            }
	        });
	    }); 
	});
	</script>
	<!-- LINKEDIN -->
	<script type="text/javascript" src="https://platform.linkedin.com/in.js">
	  api_key: 77i0wrm327h22q
	  authorize: true
	  scope: r_fullprofile r_network rw_groups rw_nus
	</script>
	<!-- Google Maps -->
	<script type="text/javascript">
		function initialize(lat, lng){
			var mapProp = {
			  center:new google.maps.LatLng(lat, lng),
			  zoom:9,
			  mapTypeId:google.maps.MapTypeId.TERRAIN
			  };
		
			var map=new google.maps.Map(document.getElementById("mapa")
			  ,mapProp);
			  
			var marcador = new google.maps.Marker({
			 	position: new google.maps.LatLng(lat, lng),
			  	map: map
			});
	
		}
		
		$(document).ready(function() { 
			$('.button.google').click(function(){

		    	var direction = document.getElementById("location").value;
		    	var latitude = '';
		    	var longitude = '';
				$('#mapa').height(300);
					
				$.ajax({
		            type: "POST",
		            url: "ajaxRequests.php",
		            data: {direction: direction, action : 'latlng'},
		            success: function(data) {
		                var array = data.split(',');
		                initialize(array[0], array[1]);
		            }
		        });
		    });              
		});    
	</script>
	<!-- Image Picker -->
	<!-- CSS -->
	<link rel="stylesheet" href="Libraries/ImagePicker/imgPicker/assets/css/imgpicker.css">
	
	<!-- JavaScript -->
	<script src="Libraries/ImagePicker/imgPicker/assets/js/jquery.Jcrop.min.js"></script>
	<script src="Libraries/ImagePicker/imgPicker/assets/js/jquery.imgpicker.js"></script>
  </head>
  <body>
  	<div id = "msg">
  		
  	</div>
  
  	<!-- Share Config -->
  	<!-- Facebook -->
  	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/es_ES/sdk.js#xfbml=1&appId=280540212146463&version=v2.0";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
	</script>
	
	<!-- Twitter -->
	<script type="text/javascript">
	window.twttr=(function(d,s,id){var t,js,fjs=d.getElementsByTagName(s)[0];if(d.getElementById(id)){return}js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);return window.twttr||(t={_e:[],ready:function(f){t._e.push(f)}})}(document,"script","twitter-wjs"));
	</script>
	
  	<div id = "cabecera">
  		<div id = "importedLinkedin" class="reveal-modal" data-reveal>
			<h1>Estamos importando tus datos, no cierres la página.</h1>
			<br>
			<img src = "<?php echo $program->getDir() ?>/img/loader.gif" width = "50px">
			<div id = "importedElementsLinkedin"></div>
		</div>
		<div id="modalLinkedin" class="reveal-modal" data-reveal>
		  <h2>Linkedin</h2>
		  <p class="lead">Necesitamos que te conectes a tu cuenta de Linkedin para copiar los datos a tu perfil.</p>
		  <script type="IN/Login" data-onAuth="onAuthLinkedin"></script>
		</div>
		<div id="connected" class="reveal-modal" data-reveal>
		  <h2>Linkedin</h2>
		  <p class="lead">Ya estás conectado/a! Ahora ya puedes importar tus datos.</p>
		  <button onclick = "instertData()" class = "button">Linkedin</button>
		</div>
		<div id="inventado" class="reveal-modal" data-reveal>
		  <h2>Error</h2>
		  <p class="lead">Auth false.</p>
		</div>
  		<div class="off-canvas-wrap" data-offcanvas>
  					<div class="inner-wrap">
  						<div class = "row">
	  						<div class = "large-10 large-offset-1 columns">
	  							<div class = "small-6 columns">
	  								<h1><a id = "secondStop" href = "?program=panel"><strong>JOB</strong>Teep</a> <a class="left-off-canvas-toggle" href="#"><img id = "thirdStop" src = "<?php echo $program->getDir() . "/img/menu_black.png" ?>" width = "40px"></a></h1>
	  							</div>
	  							<div class = "small-6 columns">
	  								<div class = "visualizar text-right"><a id = "recorrido" href="#"><img id = "seventhStop" alt = "jobteep" src = "<?php echo $program->getDir() . "/img/question.png" ?>" width = "30px"></a></div>
	  							</div>
	  						</div>
	  					</div>
	  					<aside class="left-off-canvas-menu">
	  						  <h1 class = "text-center"><strong>JOB</strong>Teep <a class="left-off-canvas-toggle" href="#"><img src = "<?php echo $program->getDir() . "/img/menu_black.png" ?>" width = "40px"></a></h1>
					    	  <ul class="off-canvas-list">
								<li><a id = "fourthStop" href="/<?php echo $info->get('domain') ?>" target = "_blank"><span><img alt = "jobteep" src = "<?php echo $program->getDir() . "/img/view.png" ?>" width = "30px"></span>&nbsp;&nbsp; Ver Curriculum</a></li>
								<li><a id = "fifthStop" href="#" onclick = "instertData()"><span><img alt = "jobteep" src = "<?php echo $program->getDir() . "/img/sync.png" ?>" width = "30px"></span>&nbsp;&nbsp; Sincronizar con Linkedin</a></li>
								<li><a id = "sixthStop" href="?program=panel&menu=settings"><span><img alt = "jobteep" src = "<?php echo $program->getDir() . "/img/settings.png" ?>" width = "30px"></span>&nbsp;&nbsp; Settings</a></li>
								<li><a href="/<?php echo $info->get('domain'); ?>/PDF" target = "_blank"><span><img alt = "jobteep" src = "<?php echo $program->getDir() . "/img/print.png" ?>" width = "30px"></span>&nbsp;&nbsp; Imprimir</a></li>
								<li><a href="?action=logout"><span><img alt = "jobteep" src = "<?php echo $program->getDir() . "/img/erase.png" ?>" width = "30px"></span>&nbsp;&nbsp; Salir</a></li>
								<li><br><span class = "share_linkedin"><script src="//platform.linkedin.com/in.js" type="text/javascript">
  									lang: es_ES
								</script>
								<script type="IN/Share" data-url="http://www.jobteep.com/<?php echo $info->get('domain') ?>"></script></span><br>
								<div class="fb-share-button" data-href="http://www.jobteep.com/<?php echo $info->get('domain') ?>" data-layout="button"></div><br>
								<a class="twitter-share-button" data-url="http://www.jobteep.com/<?php echo $info->get('domain') ?>" href="https://twitter.com/share" data-related="twitterdev" data-size="large" data-text="Échale un vistazo a mi curriculum reinventado, tu también puedes tener uno gratis!" data-count="none">Tweet</a></li>
								<!-- <a href="http://www.linkedin.com/shareArticle?mini=true&url=YourURL&title=Jobteep&summary=TheSummaryOfYourWebPageGoesHere&source=TheNameOfYourSiteGoesHere" rel="nofollow" onclick="NewWindow(this.href,'template_window','550','400','yes','center');return false" onfocus="this.blur()"></a></li> -->
						      </ul>
					    </aside>
					    <section class="main-section">
					      	<div class = "row">
						  		<div class = "large-12 columns">
						  			<?php 
							    		include $program->getDir() . $program->getInfo('content');
							    	?>
					  		</div>
					    </div>
				    </section>
				    <a class="exit-off-canvas"></a>
  				</div>
  			</div>
	</div>
	<div id = "pie_pagina">
		<div class = "row">
	  		<div class = "large-10 large-offset-1 columns">
  				<div class = "row">
		  			<div class = "large-12 columns">
		  				<div class = "large-6 columns">
		  					<small>JOBTeep &copy; Todos los derechos reservados.</small>
		  				</div>
		  				<div class = "large-6 columns">
		  					<ul>
		  						<li><small>Política de privacidad</small></li>
		  						<li><small>Ley de Cookies</small></li>
		  						<li><small>Contacto</small></li>
		  					</ul>
		  				</div>
		  			</div>
		  		</div>
	  		</div>
  		</div>
	</div>
  	
  	<!-- Avatar Modal -->
	<div class="ip-modal" id="avatarModal">
		<div class="ip-modal-dialog">
			<div class="ip-modal-content">
				<div class="ip-modal-header">
					<a class="ip-close" title="Close">&times;</a>
					<h4 class="ip-modal-title">Cambiar Avatar</h4>
				</div>
				<div class="ip-modal-body">
					<div class="btn btn-primary ip-upload">Subir <input type="file" name="file" class="ip-file"></div>
					<button class="btn btn-primary ip-webcam">Webcam</button>
					<button type="button" class="btn btn-info ip-edit">Editar</button>
					<button type="button" class="btn btn-danger ip-delete">Eliminar</button>
					
					<div class="alert ip-alert"></div>
					<div class="ip-info">To crop this image, drag a region below and then click "Save Image"</div>
					<div class="ip-preview"></div>
					<div class="ip-rotate">
						<button type="button" class="btn btn-default ip-rotate-ccw" title="Rotate counter-clockwise"><i class="icon-ccw"></i></button>
						<button type="button" class="btn btn-default ip-rotate-cw" title="Rotate clockwise"><i class="icon-cw"></i></button>
					</div>
					<div class="ip-progress">
						<div class="text">Subiendo</div>
						<div class="progress progress-striped active"><div class="progress-bar"></div></div>
					</div>
				</div>
				<div class="ip-modal-footer">
					<div class="ip-actions">
						<button class="btn btn-success ip-save">Retocado</button>
						<button class="btn btn-primary ip-capture">Capturar</button>
						<button class="btn btn-success ip-cancel">Original</button>
					</div>
					<button class="btn btn-default ip-close">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
	<!-- end Modal -->
	
	<!-- Header Modal -->
	<div class="ip-modal" id="headerModal">
		<div class="ip-modal-dialog">
			<div class="ip-modal-content">
				<div class="ip-modal-header">
					<a class="ip-close" title="Close">&times;</a>
					<h4 class="ip-modal-title">Cambiar imagen</h4>
					<div class = "grsr">Puedes arrastrar aquí las imagenes para subirlas</div>
				</div>
				<div class="ip-modal-body">
					<div class="btn btn-primary ip-upload">Subir <input type="file" name="file" class="ip-file"></div>
					<!-- <button class="btn btn-primary ip-webcam">Webcam</button> -->
					<button type="button" class="btn btn-info ip-edit">Editar</button>
					<button type="button" class="btn btn-danger ip-delete">Eliminar</button>
					
					<div class="alert ip-alert"></div>
					<div class="ip-info">Para recortar la imagen, selecciona una región y entonces haz click en  "Guardar Imagen"</div>
					<div class="ip-preview"></div>
					<div class="ip-rotate">
						<button type="button" class="btn btn-default ip-rotate-ccw" title="Rotate counter-clockwise"><i class="icon-ccw"></i></button>
						<button type="button" class="btn btn-default ip-rotate-cw" title="Rotate clockwise"><i class="icon-cw"></i></button>
					</div>
					<div class="ip-progress">
						<div class="text">Subiendo</div>
						<div class="progress progress-striped active"><div class="progress-bar"></div></div>
					</div>
				</div>
				<div class="ip-modal-footer">
					<div class="ip-actions">
						<button class="btn btn-success ip-save">Retocado</button>
						<button class="btn btn-primary ip-capture">Capturar</button>
						<button class="btn btn-success ip-cancel">Original</button>
					</div>
					<button class="btn btn-default ip-close">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
	<!-- end Modal -->
	
	<div id = "recorrido_content">
		<ol class="joyride-list" data-joyride>
			<li class = "text-center" data-button="OK" data-text="Next" data-options="prev_button: false">
				<h4>Bienvenido!</h4>
				<br>
				<p>Voy a enseñarte la oficina.</p>
			</li>
			<li data-id="firstStop" data-text="Siguiente" data-options="tip_location: top; prev_button: false">
				<p>Estas son las tarjetas, aquí es donde añades la info de tu curriculum.</p>
			</li>
			<li data-id="secondStop" data-text="Siguiente" data-prev-text="Anterior" data-options="tip_location: bottom;">
				<p>Si pinchas en JOBTeep, siempre te traerá a esta pantalla, la principal.</p>
			</li>
			<li data-id="thirdStop" data-text="Siguiente" data-prev-text="Anterior" data-options="tip_location: bottom;">
				<p>Pinchando aquí puedes acceder al <b>Menú de Opciones</b> donde podrás: <b>visualizar</b> tu curriculum, <b>sincronizar</b> tus datos <b>con Linkedin, settings, imprimir y compartir.</b></p>
			</li>
			<li class = "text-center" data-button="Siguiente" data-text="Next" data-options="prev_button: false">
				<p>No te olvides de configurar la visualización de tu curriculum en <b>"SETTINGS"</b>.</p>
			</li>
			<li data-id="seventhStop" data-text="Siguiente" data-prev-text="Anterior" data-options="tip_location: left;">
				<p>Pinchando aquí podrás ver la <b>ayuda</b> de la página en la que estés, principalmente en los formularios.</p>
			</li>
			<li class = "text-center" data-button="OK" data-text="Next" data-options="prev_button: false">
				<h4>Ya está!</h4>
				<br>
				<p>Ahora <b>sincroniza con Linkedin</b> o añade algo de información, configura algunos parámetros en <b>"SETTINGS"</b> y ve a ver tu curriculum en <b>"VISUALIZAR"</b>.</p>
				<br>
				<p>Hasta pronto!</p>
			</li>
		</ol>
	</div>
	
	<div id = "recorrido_info">
		<ol class="joyride-list" data-joyride>
			<li data-id="info_sectores" data-text="Siguiente" data-options="tip_location: top; prev_button: false">
				<p>Los sectores son importantes para que las empresas te encuentren.</p>
			</li>
			<li data-id="info_nativo" data-text="Siguiente" data-prev-text="Anterior" data-options="tip_location: bottom;">
				<p>Este idioma aparece por defecto en la visualización, no hace falta que lo añadas a idiomas.</p>
			</li>
			<li data-id="info_dominio" data-text="OK" data-options="tip_location: top; prev_button: false">
				<p>Puedes cambiar tu dominio siempre que esté disponible.</p>
			</li>
		</ol>
	</div>
	<div id = "recorrido_exp">
		<ol class="joyride-list" data-joyride>
			<li data-id="exp_sectores" data-text="Siguiente" data-options="tip_location: top; prev_button: false">
				<p>Los sectores clasifican los trabajos, son importantes para identificar tus fortalezas.</p>
			</li>
			<li data-id="exp_description" data-text="Siguiente" data-prev-text="Anterior" data-options="tip_location: bottom;">
				<p>No te olvides de incluir las tareas que realizabas.</p>
			</li>
			<li data-id="exp_language" data-text="Siguiente" data-prev-text="Anterior" data-options="tip_location: bottom;">
				<p>Idiomas que has practicado en el trabajo.</p>
			</li>
			<li data-id="exp_travel" data-text="Siguiente" data-prev-text="Anterior" data-options="tip_location: bottom;">
				<p>Viajes que has realizado por el trabajo.</p>
			</li>
			<li data-id="exp_skill" data-text="OK" data-options="tip_location: top; prev_button: false">
				<p>Aptitudes que has desarrollado durante el trabajo.</p>
			</li>
		</ol>
	</div>
	<div id = "recorrido_edu">
		<ol class="joyride-list" data-joyride>
			<li data-id="edu_sectores" data-text="Siguiente" data-options="tip_location: top; prev_button: false">
				<p>Los sectores clasifican la formación, son importantes para identificar tus fortalezas.</p>
			</li>
			<li data-id="edu_description" data-text="Siguiente" data-prev-text="Anterior" data-options="tip_location: bottom;">
				<p>No te olvides de destacar los conocimientos que aprendiste que estén relacionados con lo que buscas ahora.</p>
			</li>
			<li data-id="edu_certificate" data-text="Siguiente" data-prev-text="Anterior" data-options="tip_location: bottom;">
				<p>Si tienes un certificado de la formación, sumarás puntos si lo adjuntas.</p>
			</li>
			<li data-id="edu_language" data-text="Siguiente" data-prev-text="Anterior" data-options="tip_location: bottom;">
				<p>Idiomas que has aprendido o desarrollado en la formación.</p>
			</li>
			<li data-id="edu_travel" data-text="Siguiente" data-prev-text="Anterior" data-options="tip_location: bottom;">
				<p>Viajes que has realizado por la formación.</p>
			</li>
			<li data-id="edu_skill" data-text="OK" data-options="tip_location: top; prev_button: false">
				<p>Aptitudes que has desarrollado durante la formación.</p>
			</li>
		</ol>
	</div>
	<div id = "recorrido_apt">
		<ol class="joyride-list" data-joyride>
			<li data-id="apt_def" data-text="OK" data-options="tip_location: top; prev_button: false">
				<p>Las aptitudes son capacidades para realizar adecuadamente ciertas actividades, funciónes o servicios. Podemos analizar tus puntos fuertes con ellas.</p>
			</li>
		</ol>
	</div>
	<div id = "recorrido_proy">
		<ol class="joyride-list" data-joyride>
			<li data-id="proy_own" data-text="Siguiente" data-options="tip_location: top; prev_button: false">
				<p>Indica si el proyecto está relacionado con alguna formación o trabajo, o bien es por iniciativa propia.</p>
			</li>
			<li data-id="proy_trab" data-text="Siguiente" data-prev-text="Anterior" data-options="tip_location: bottom;">
				<p>Si el proyecto lo has realizado durante un trabajo, indica que trabajo para que podamos relacionarlos.</p>
			</li>
			<li data-id="proy_edu" data-text="Siguiente" data-prev-text="Anterior" data-options="tip_location: bottom;">
				<p>Si el proyecto lo has realizado durante una formación, indica cual para que podamos relacionarlos.</p>
			</li>
			<li data-id="proy_sectores" data-text="Siguiente" data-options="tip_location: top; prev_button: false">
				<p>Los sectores clasifican los proyectos, son importantes para identificar tus fortalezas.</p>
			</li>
			<li data-id="proy_description" data-text="Siguiente" data-prev-text="Anterior" data-options="tip_location: bottom;">
				<p>No te olvides de destacar los conocimientos nuevos que aprendiste, las responsabilidades que adquiriste y los errores de los que has aprendido.</p>
			</li>
			<li data-id="proy_language" data-text="Siguiente" data-prev-text="Anterior" data-options="tip_location: bottom;">
				<p>Idiomas que has practicado en el proyecto.</p>
			</li>
			<li data-id="proy_travel" data-text="Siguiente" data-prev-text="Anterior" data-options="tip_location: bottom;">
				<p>Viajes que has realizado por el proyecto.</p>
			</li>
			<li data-id="proy_skill" data-text="Siguiente" data-prev-text="Anterior" data-options="tip_location: bottom;">
				<p>Aptitudes que has desarrollado durante el proyecto.</p>
			</li>
			<li class = "text-center" data-button="OK" data-text="Next" data-options="prev_button: false">
				<p>En cuanto guardes el proyecto podrás adjuntarle imágenes.</p>
			</li>
		</ol>
	</div>
	
    <script src="Libraries/foundation/js/vendor/fastclick.js"></script>
    <script src="Libraries/foundation/js/foundation.min.js"></script>
  	<script src="Libraries/foundation/js/foundation/foundation.joyride.js"></script>
    <script>
      $(document).foundation();
    </script>
    <script> 
		$(function() {
			var time = function(){return'?'+new Date().getTime()};
			
			// Avatar setup
			$('#avatarModal').imgPicker({
				url: 'Libraries/ImagePicker/imgPicker/server/upload_avatar.php',
				aspectRatio: 1, // Crop aspect ratio
				// Delete callback
				deleteComplete: function() {
					$('#avatar').attr('src', '<?php echo $program->getDir() ?>img/profile.png');
					$('#perfil').attr('value', '');
					this.modal('hide');
				},
				// Crop success callback
				cropSuccess: function(image) {
					console.log(image);
					$('#avatar').attr('src', image.versions.avatar.url + time());
					$('#perfil').attr('value', image.versions.avatar.name);
					/*this.modal('hide');*/
				},
				uploadSuccess: function(image) {
					console.log(image);
					$('#avatar').attr('src', image.versions.avatar.url + time());
					$('#perfil').attr('value', image.versions.avatar.name);
					this.modal('hide');
				},
				// Send some custom data to server
				data: {
					k: 'value',
				}
			});

			// Header setup
			$('#headerModal').imgPicker({
				url: 'Libraries/ImagePicker/imgPicker/server/upload_header.php',
				aspectRatio: 32/10,
				deleteComplete: function() {
					$('#header_img').attr('src', '');
					$('#perfil').attr('value', '');
					this.modal('hide');
				},
				cropSuccess: function(image) {
					$('#header_img').attr('src', image.versions.header.url + time());
					$('#perfil').attr('value', image.versions.header.name);
					/*this.modal('hide');*/
				},
				uploadSuccess: function(image) {
					$('#header_img').attr('src', image.url + time());
					$('#perfil').attr('value', image.name);
					this.modal('hide');
				},
				// Send some custom data to server
				data: {
					k: 'value',
				}
			});
		}); 
	</script>
	<!-- CKEDITOR -->
	<script type="text/javascript">
		var ck_description = CKEDITOR.replace( 'ck_description' );
		var ck_description2 = CKEDITOR.replace( 'ck_description2' );
		var ck_description3 = CKEDITOR.replace( 'ck_description3' );
	    var ck_short_description = CKEDITOR.replace( 'ck_short_description' );
	    
		CKFinder.setupCKEditor( ck_description, 'Libraries/ckfinder/' );
	</script>
  </body>
</html>
