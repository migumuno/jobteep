<?php 
$controller = $_SESSION['SO']->getController();
$controller->checkSiteMap("Sitemaps/Usuarios/users.xml");
?>
<!DOCTYPE html> 
<html>
<head>
	<title>JobTeep</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="Libraries/foundation/css/foundation.css" />
    <link rel="stylesheet" href="Libraries/foundation/css/normalize.css" />
    <link rel="stylesheet" href="<?php echo $program->getDir(); ?>css/app.css" />
	<link rel="stylesheet" href="<?php echo $program->getDir() ?>css/themes/jobteep.css" />
    <link rel="stylesheet" href="<?php echo $program->getDir() ?>css/themes/jquery.mobile.icons.min.css" />
    <script src="Libraries/foundation/js/vendor/modernizr.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
	<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
</head>

<body>
	<!-- Comienzo página 1 -->
	<div data-role="page" id = "enter">
		<div data-role="header">
			<h1>JobTeep</h1>
			<a href="http://www.jobteep.com/main.php?action=applogout" target = "_blank" class="ui-btn ui-icon-delete ui-btn-icon-notext ui-corner-all">No text</a>
		</div>
		<div role="main" class="ui-content">
			<div class = "row">
				<div class = "small-6 columns card">
					<div class = "panel">
						<h2 class = "titulo">usuarios</h2>
						<p posicion = "center" class = "xxl"><?php echo $controller->numUsers('total') ?></p>
					</div>
				</div>
				<div class = "small-6 columns card">
					<div class = "panel">
						<h2 class = "titulo">usuarios</h2>
						<p posicion = "center" class = "xxl"><?php echo $controller->numUsers('week') ?></p>
					</div>
				</div>
			</div>
		</div>
		<div data-role="footer">
			<h4>JobTeep | Administración</h4>
		</div>
	</div> <!-- /página 1 -->
	
	
	<script src="Libraries/foundation/js/vendor/fastclick.js"></script>
    <script src="Libraries/foundation/js/foundation.min.js"></script>
  	<script src="Libraries/foundation/js/foundation/foundation.joyride.js"></script>
    <script>
      $(document).foundation();
    </script>
</body>
</html>