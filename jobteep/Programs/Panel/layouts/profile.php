<!doctype html>
<html class="no-js" lang="es">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $program->getInfo('title'); ?></title>
    <meta name="description" content="<?php echo $program->getInfo('description'); ?>">
	<meta name="keywords" content="<?php echo $program->getInfo('keywords'); ?>">
	<meta name="author" content="Miguel Ángel Muñoz Viejo">
    <link rel="stylesheet" href="<?php echo $program->getDir(); ?>css/foundation.css" />
    <link href="http://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Merriweather+Sans:700,400,800italic,700italic,400italic' rel='stylesheet' type='text/css'>
    <script src="<?php echo $program->getDir(); ?>js/vendor/modernizr.js"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/cupertino/jquery-ui.css " />
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
	<script>
	$(function () {
		$("#dp1").datepicker({
			dateFormat: 'yy/mm/dd',
			changeYear: true,
			changeMonth: true
		});
		$("#dp2").datepicker({
			dateFormat: 'yy/mm/dd',
			changeYear: true,
			changeMonth: true
		});
	});
	</script>
  </head>
  <body>
  	<div class = "row">
  		<div class="off-canvas-wrap" data-offcanvas>
		  <div class="inner-wrap">
		    <nav class="tab-bar">
		      <section class="left-small">
		        <a class="left-off-canvas-toggle menu-icon" href="#"><span></span></a>
		      </section>
		
		      <section class="middle tab-bar-section">
		        <h1 class="title text-center">The Jobfeel</h1>
		      </section>
		      
		      <section class="right-small">
		        <a href="?action=logout"><span><img src = "Programs/Panel/img/close.png"></span></a>
		      </section>
		    </nav>
		
		    <aside class="left-off-canvas-menu">
		      <ul class="off-canvas-list">
		        <!-- <li><label>Contenido</label></li>
		        <li><a href="?program=panel&menu=new_experience">Experiencia</a></li>
		        <li><a href="?program=panel&menu=new_language">Idiomas</a></li>
		        <li><a href="?program=panel&menu=new_skill">Habilidades</a></li> -->
		      </ul>
		      <ul class="off-canvas-list">
		        <!-- <li><label>Configuración</label></li>
		        <li><a href="#">Sobre mí</a></li> -->
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
  	</div>
  	
   	<script src="<?php echo $program->getDir() ?>js/vendor/fastclick.js"></script>
    <script src="<?php echo $program->getDir() ?>js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
  </body>
</html>