<!doctype html>
<html class="no-js" lang="es">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $program->getInfo('title'); ?></title>
    <meta name="description" content="<?php echo $program->getInfo('description'); ?>">
	<meta name="keywords" content="<?php echo $program->getInfo('keywords'); ?>">
	<meta name="author" content="Miguel Ángel Muñoz Viejo">
	<meta name="robots" content="NOINDEX, NOFOLLOW">
	<link href="<?php echo $program->getDir(); ?>img/logo.jpg" rel="image_src">
    <link rel="stylesheet" href="<?php echo $program->getDir(); ?>css/foundation.css" />
    <link href='http://fonts.googleapis.com/css?family=Merriweather+Sans:700,400,800italic,700italic,400italic' rel='stylesheet' type='text/css'>
    <script src="<?php echo $program->getDir(); ?>js/vendor/modernizr.js"></script>
    <script src="<?php echo $program->getDir(); ?>js/validation.js"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/cupertino/jquery-ui.css " />
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
    <script type="text/javascript">
		$(document).ready(function() {    
		    $('#user').change(function(){
		
		        $('#user_error').html('<img src="Programs/Web/img/loader.gif" alt="" width = "20px" />').fadeOut(1000);
		
		        var user = $(this).val();
		
		        $.ajax({
		            type: "POST",
		            url: "ajaxRequests.php",
		            data: {user: user, action : 'register'},
		            success: function(data) {
		                $('#user_error').fadeIn(1).html(data);
		            }
		        });
		    });              
		});    
	</script>
	<script>
		function avisos (message) {
			$('#message').html(message);
			$('#aviso').foundation('reveal', 'open');
		}
	</script>
  </head>
  <body>
  	<div class = "row">
  		<div class = "large-12 medium-12 small-12 columns">
  			<div class = "space"></div>
  		</div>
  	</div>
    <div class = "row">
    	<div class = "large-6 large-offset-1 medium-5 medium-offset-1 small-10 small-offset-1 columns">
    		<div class = "row">
    			<div class = "margen">
    				<h1 class = "text-center" style = "color:#ffffff;">The <strong>JOB</strong>Feel, <small style = "color:#333333;">reinventamos tu curriculum.</small></h1>
    			</div>
    		</div>
    	</div>
    	<div class = "large-4 medium-6 columns end">
    		<div class = "medium-8 medium-offset-2 columns panel">
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
