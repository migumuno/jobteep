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
    <link rel="stylesheet" href="<?php echo $program->getDir(); ?>css/app.css" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href="http://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
    <script src="Libraries/foundation/js/vendor/modernizr.js"></script>
    <script src="<?php echo $program->getDir(); ?>js/intro.js"></script>
    <link rel="stylesheet" href="Libraries/jquery-ui/jquery-ui.css " />
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
	<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBvb5rGbk9ELMY_XYKViUIW-QyKnJluvu0&sensor=false"></script>
	<!-- Jquery File Upload -->
	<link rel="stylesheet" href="Libraries/jQuery-File-Upload-master/css/jquery.fileupload.css">
	<link rel="stylesheet" href="Libraries/jQuery-File-Upload-master/css/style.css">
	<script>
		$(document).ready(function () {
			$( "#msg" ).html('<h4>Tu cuenta ya está activada! Rellena unos pocos datos para empezar.</h4>');
			$( "#msg" ).fadeIn( "slow");
			$( "#msg" ).click(function() {
			  $( "#msg" ).fadeOut( "slow", function() {
				  $( "#msg" ).html('');
			  });
			});
		});
	</script>
	<script>
	$(function () {
		var fecha = new Date();
		var anno = fecha.getFullYear() + 1;
		$("#birthday").datepicker({
			dateFormat: 'yy/mm/dd',
			yearRange: "1900:"+anno,
			changeYear: true,
			changeMonth: true
		});
	});
	</script>
	<!-- LINKEDIN -->
	<script type="text/javascript" src="https://platform.linkedin.com/in.js">
	  api_key: 77i0wrm327h22q
	  authorize: true
	  scope: r_fullprofile
	</script>
	<script>
		function onAuthLinkedin () {
			document.getElementById("modalLinkedin").innerHTML = 
				"<h2>Linkedin</h2><p class=\"lead\">Ya estás conectado/a! Ahora ya puedes importar tus datos.</p><br><p><button onclick = \"instertData()\" class = \"button\">Importar</button> <button onclick = \"$('#modalLinkedin').foundation('reveal', 'close');\" class = \"button\">Cancelar</button></p>";
		}
	</script>
	<script type="text/javascript">
		function instertData() {	
			var auth = true;
			
			try {
				IN.API.Profile("me").fields(["firstName", "lastName", "pictureUrl", "id", "date-of-birth", "headline", "summary"]).result(displayProfiles);
				IN.API.Raw("/people/~/picture-urls::(original)")
			      .result(displayPicture);
			} catch (err) {
				auth = false;
				$('#modalLinkedin').foundation('reveal', 'open');
			}

			function displayPicture (picture) {
				document.Intro.avatar.src = picture.values[0];
				document.Intro.perfil.value = picture.values[0];
			}
			
	      	function displayProfiles(profiles) {
		      	member = profiles.values[0];
	      	   	document.Intro.name.value = member.firstName;
	      	   	document.Intro.profession.value = member.headline;
	      	   	document.Intro.description.value = member.summary.replace(/"/g, "&amp;quot;").replace(/'/g, "&amp;quot;");
	      	   	document.Intro.id_lnkdn.value = member.id;
	      	   	document.Intro.surname.value = member.lastName;
	      	    /*document.Intro.avatar.src = member.pictureUrl;*/
	      	    if (member.dateOfBirth.day < 10)
	      	    	var day = "0" + member.dateOfBirth.day;
	      	    else 
		      	    var day = member.dateOfBirth.day;
	      	    if (member.dateOfBirth.month < 10)
		      	    var month = "0" + member.dateOfBirth.month;
	      	    else
		      	    var month = member.dateOfBirth.month;
	      	    document.Intro.birthday.value = member.dateOfBirth.year + "-" + month + "-" + day;

	      	  document.getElementById("modalLinkedin").innerHTML = 
					"<h2>Todo listo!</h2>";
	      	}
	      	if (!auth)
	    		$('#modalLinkedin').foundation('reveal', 'open');
		}
	</script>
	<!-- Image Picker -->
	<!-- CSS -->
	<link rel="stylesheet" href="Libraries/ImagePicker/imgPicker/assets/css/imgpicker.css">
	
	<!-- JavaScript -->
	<script src="Libraries/ImagePicker/imgPicker/assets/js/jquery.Jcrop.min.js"></script>
	<script src="Libraries/ImagePicker/imgPicker/assets/js/jquery.imgpicker.js"></script>
	<script type="text/javascript">
		function initialize(lat, lng){
			var mapProp = {
			  center:new google.maps.LatLng(lat, lng),
			  zoom:9,
			  mapTypeId:google.maps.MapTypeId.TERRAIN
			  };
		
			var map=new google.maps.Map(document.getElementById("mapa")
			  ,mapProp);
			  
			/*var marcador = new google.maps.Marker({
			 	position: new google.maps.LatLng(lat, lng),
			  	map: map
			});*/
	
		}
		
		$(document).ready(function() { 
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
		    
		    $('.google').click(function(){
		    	var x = document.getElementById("mapa");

		    	if (navigator.geolocation) {
	    	        navigator.geolocation.getCurrentPosition(showPosition);
	    	    } else { 
	    	        x.innerHTML = "Geolocation is not supported by this browser.";
	    	    }

		    	function showPosition(position) {
		    		var latlng = position.coords.latitude+","+position.coords.longitude;
					$('#mapa').height(300);
					
					
					$.ajax({
			            type: "POST",
			            url: "ajaxRequests.php",
			            data: {direction: latlng, action : 'location'},
			            success: function(data) {
			            	var array = data.split(',');
			                document.Intro.city.value = array[0];
			                document.Intro.country.value = array[1];
			            }
			        });

					/*$.ajax({
			            type: "POST",
			            url: "ajaxRequests.php",
			            data: {direction: latlng, action : 'country'},
			            success: function(data) {
			                document.Intro.country.value = data;
			            }
			        });*/

					/*initialize(position.coords.latitude, position.coords.longitude);*/
		    	}
		    });              
		});    
	</script>
  </head>
  <body>
  	<div id = "msg">
  		
  	</div>
  	<div id = "cabecera">
		<div id="inventado" class="reveal-modal" data-reveal>
		  <h2>Error</h2>
		  <p class="lead">Auth false.</p>
		</div>
	  	<div class = "row">
	  		<div class = "large-10 large-offset-1 columns">
	  			<h1><img src = "<?php echo $program->getDir() ?>img/logo.png" width = "50" alt = "logo jobteep"> JobTeep</h1>
	  		</div>
	  	</div>
	</div>
  	<div class = "row">
  		<div class = "large-10 large-offset-1 columns">
  			<?php 
	    		include $program->getDir() . $program->getInfo('content');
	    	?>
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
  	
  	<script src="Libraries/foundation/js/vendor/fastclick.js"></script>
    <script src="Libraries/foundation/js/foundation.min.js"></script>
  	<script src="Libraries/foundation/js/foundation/foundation.abide.js"></script>
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
					this.modal('hide');
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
		}); 
	</script>
  </body>
</html>