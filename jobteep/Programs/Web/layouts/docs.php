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
    <link href='http://fonts.googleapis.com/css?family=Merriweather+Sans:700,400,800italic,700italic,400italic' rel='stylesheet' type='text/css'>
    <script src="<?php echo $program->getDir(); ?>js/vendor/modernizr.js"></script>
  </head>
  <body>
  	<div class = "row">
  		<div class = "docs">
	    	<div class = "large-8 large-offset-2 columns panel callout radius">
	    		<?php 
		    	include $program->getDir() . $program->getInfo('content');
		    	?>
	    	</div>
	    </div>
    </div>
    
    <script src="<?php echo $program->getDir() ?>js/vendor/fastclick.js"></script>
    <script src="<?php echo $program->getDir() ?>js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
  </body>
</html>
