<?php 
include_once 'Libraries/ckfinder/ckfinder.php';
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
    <link rel="stylesheet" href="Libraries/foundation/css/foundation.css" />
    <link rel="stylesheet" href="Libraries/foundation/css/normalize.css" />
    <link rel="stylesheet" href="Libraries/foundation/css/app.css" />
    <link href="http://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
    <script src="Libraries/foundation/js/vendor/modernizr.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/cupertino/jquery-ui.css " />
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
	<script type="text/javascript" src="Libraries/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="Libraries/ckfinder/ckfinder.js"></script>
	<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBvb5rGbk9ELMY_XYKViUIW-QyKnJluvu0&sensor=false"></script>
	<!-- Jquery File Upload -->
	<link rel="stylesheet" href="Libraries/jQuery-File-Upload-master/css/style.css">
	
	<!-- Image Picker -->
	<!-- CSS -->
	<link rel="stylesheet" href="Libraries/ImagePicker/imgPicker/assets/css/imgpicker.css">
	
	<!-- JavaScript -->
	<script src="Libraries/ImagePicker/imgPicker/assets/js/jquery.Jcrop.min.js"></script>
	<script src="Libraries/ImagePicker/imgPicker/assets/js/jquery.imgpicker.js"></script>
  </head>
  <body>
  	<div id = "cabecera">
	  	<div class="off-canvas-wrap" data-offcanvas>
  					<div class="inner-wrap">
  						<div class = "row">
	  						<div class = "large-10 large-offset-1 columns">
	  							<h1><a href = "?program=panel"><small>The</small> <strong>JOB</strong>Feel</a> <a class="left-off-canvas-toggle" href="#"><img src = "<?php echo $program->getDir() . "/img/menu.png" ?>" width = "40px"></a></h1>
	  						</div>
	  					</div>
	  					<aside class="left-off-canvas-menu">
	  						  <h1 class = "text-center"><small>The</small> <strong>JOB</strong>Feel <a class="left-off-canvas-toggle" href="#"><img src = "<?php echo $program->getDir() . "/img/menu.png" ?>" width = "40px"></a></h1>
					    	  <ul class="off-canvas-list">
						      	<li><a href="?program=panel&menu=info"><span><img alt = "the jobfeel" src = "Programs/Panel/img/menu/info_white.png" width = "30px"></span>&nbsp;&nbsp; Datos Personales</a></li>
						      	<li><a href="?program=panel&menu=experience"><span><img alt = "the jobfeel" src = "Programs/Panel/img/menu/experience_white.png" width = "30px"></span>&nbsp;&nbsp; Trabajos</a></li>
						      	<li><a href="?program=panel&menu=education"><span><img alt = "the jobfeel" src = "Programs/Panel/img/menu/education_white.png" width = "30px"></span>&nbsp;&nbsp; Formación</a></li>
						        <li><a href="?program=panel&menu=language"><span><img alt = "the jobfeel" src = "Programs/Panel/img/menu/languages_white.png" width = "30px"></span>&nbsp;&nbsp; Idiomas</a></li>
						        <li><a href="?program=panel&menu=skill"><span><img alt = "the jobfeel" src = "Programs/Panel/img/menu/skills_white.png" width = "30px"></span>&nbsp;&nbsp; Habilidades</a></li>
						        <li><a href="?program=panel&menu=proyect"><span><img alt = "the jobfeel" src = "Programs/Panel/img/menu/proyect_white.png" width = "30px"></span>&nbsp;&nbsp; Proyectos</a></li>
						        <li><a href="?program=panel&menu=activity"><span><img alt = "the jobfeel" src = "Programs/Panel/img/menu/activity_white.png" width = "30px"></span>&nbsp;&nbsp; Actividades</a></li>
						        <li><a href="?program=panel&menu=travel"><span><img alt = "the jobfeel" src = "Programs/Panel/img/menu/countries_white.png" width = "30px"></span>&nbsp;&nbsp; Mis Viajes</a></li>
						        <li><a href="?program=panel&menu=mtl"><span><img alt = "the jobfeel" src = "Programs/Panel/img/menu/hobbies_white.png" width = "30px"></span>&nbsp;&nbsp; Mi tiempo libre</a></li>
						      	<li><a href="?action=logout"><span><img src = "Programs/Panel/img/close.png" width = "30px"></span>&nbsp;&nbsp; Salir</a></li>
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
		  					<small>The JOBFeel &copy; Todos los derechos reservados.</small>
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
  	
    
    <script src="Libraries/foundation/js/vendor/fastclick.js"></script>
    <script src="Libraries/foundation/js/foundation.min.js"></script>
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
					/*this.modal('hide');*/
				},
				// Send some custom data to server
				data: {
					k: 'value',
				}
			});

			// Header setup
			$('#headerModal').imgPicker({
				url: 'Libraries/ImagePicker/imgPicker/server/upload_header.php',
				aspectRatio: 32/7,
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
					/*this.modal('hide');*/
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
	    var ck_short_description = CKEDITOR.replace( 'ck_short_description' );
		CKFinder.setupCKEditor( ck_description, 'Libraries/ckfinder/' );
	</script>
  </body>
</html>
