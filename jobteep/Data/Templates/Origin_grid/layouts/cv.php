<?php
	$controller = $_SESSION['SO']->getController();
	$info = $controller->getUserInfo();
	$UID = $info['id_user'];
	$controller->setUID ($UID);
	$controller->setUser ($info['user']);
	$controller->setVersion ($info['version']);
	$settings = $controller->getSettings ();
	$template = $controller->getTemplateInfo ($UID, $info['template']);
?>
<!doctype html>
<html class="no-js" lang="es">
<head>
	<meta charset="utf-8" />
    <title><?php echo $info['name'].' '.$info['surname']; ?></title>
    <meta name="description" content="<?php echo $program->getInfo('description'); ?>">
	<meta name="keywords" content="<?php echo $program->getInfo('keywords'); ?>">
	<meta name="author" content="Miguel Ángel Muñoz Viejo"><meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="Libraries/foundation/css/foundation.css" />
    <link rel="stylesheet" href="<?php echo $program->getDir(); ?>css/app.css" />
    <script src="Libraries/foundation/js/vendor/modernizr.js"></script>
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
	<script>
		$(document).ready(function () {
			var height = $( window ).height() - 10;
			var width = $( window ).width();
			if (height > 600) {
				var datos = (height / 3) * 2;
				$(".datos").css('height', datos);
				$(".conocimientos").css('height', height / 3);
				$(".vivencias").css('height', height / 3);
				$(".inspiracion").css('height', height / 3);
				$(".creaciones").css('height', height / 3);
				$(".deseos").css('height', height / 3);
			}
		});
	</script>
</head>
<body>
	<div id = "log"></div>
	<?php
    include $program->getDir() . $program->getInfo('content'); 
	?>
	<script src="Libraries/foundation/js/vendor/fastclick.js"></script>
    <script src="Libraries/foundation/js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
</body>
</html>