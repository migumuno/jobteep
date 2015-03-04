<!DOCTYPE html> 
<html>
<head>
	<title>JobTeep</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="<?php echo $program->getDir() ?>img/favicon.ico">
	<link rel="icon" href="<?php echo $program->getDir() ?>img/favicon.png">
	<link rel="apple-touch-icon-precomposed" href="<?php echo $program->getDir() ?>img/apple.png">
	<link rel="stylesheet" href="<?php echo $program->getDir() ?>css/admin.css" />
    <link rel="stylesheet" href="<?php echo $program->getDir() ?>css/themes/jquery.mobile.icons.min.css" />
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
</head>

<body>
	<!-- Comienzo página 1 -->
	<div data-role="page" id = "enter">
		<div data-role="header">
			<h1>JobTeep</h1>
		</div>
		<div role="main" class="ui-content">
			<form method = "post" action = "?menu=admin&action=applogin">
				<label for="user">Usuario</label>
				<input type="text" name="user" id="user" value="">
				<label for="password">Contraseña:</label>
				<input type="password" name="pass" id="pass" value="" autocomplete="off">
				<input type="submit" value="Entrar">
			</form>
		</div>
		<div data-role="footer">
			<h4>Page Footer</h4>
		</div>
	</div> <!-- /página 1 -->
</body>
</html>