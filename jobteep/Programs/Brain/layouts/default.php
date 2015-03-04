<?php 
$controller = $_SESSION['SO']->getController();
?>
<!doctype html>
<html class="no-js" lang="es">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $program->getInfo('title'); ?></title>
    <link rel="stylesheet" href="Libraries/foundation/css/foundation.css" />
    <link rel="stylesheet" href="<?php echo $program->getDir(); ?>css/app.css" />
    <script src="Libraries/foundation/js/vendor/modernizr.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/cupertino/jquery-ui.css " />
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
	<script src="http://d3js.org/d3.v3.min.js"></script>
	<script src="<?php echo $program->getDir(); ?>js/bullet.js"></script>
	<script type="text/javascript">
	$(document).ready(function () {
		var height = $( window ).height();
		$(".content").css('min-height', height);
	});
	</script>
  </head>
  <body>
  	<div class = "content row panel">
  		<div class = "large-12 columns">
	  		<h1>Bienvenido a Cerebro <?php echo $controller->getAdminName(); ?></h1>
	    	<form method = "post" action = "?program=brain&action=command">
	    		<div class = "row">
	    			<div class = "large-1 small-2 columns"><span class="prefix text-right">></span></div>
	    			<div class = "large-11 small-10 columns"><input type = "text" name = "command" autocomplete="off" autofocus></div>
	    		</div>
	    	</form>
	    	<div id = "content">
	    		<?php echo $controller->title; ?>
	    		<div id = "graphic"></div>
	    		<?php echo $controller->getMessage(); ?>
	    	</div>
	    </div>
  	</div>
  
  	<script src="Libraries/foundation/js/vendor/fastclick.js"></script>
    <script src="Libraries/foundation/js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
  </body>
</html>