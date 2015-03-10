<?php 
$controller = $_SESSION['SO']->getController();
$info = $controller->getUserInfo();
$_SESSION['teepcard'] = array(
		"nombre" => $info['name'],
		"apellido" => $info['surname'],
		"profesion" => $info['profession'],
		"email" => $info['email'],
		"telf" => $info['telf1'],
		"dominio" => $info['domain']
);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<base href="http://www.jobteep.com/" target="_blank">
	<title>TeepCard</title>
	<style type="text/css">
		body {
			background-color: #c0c1c5;
		}
		
		.teepcard {
			box-shadow: 0px 5px 8px #888888;
		}
		
		.teepcard_container {
			width: 600px;
			margin: 0 auto;
		}
	</style>
</head>
<body>
	<div class = "teepcard_container"><img class = "teepcard" src = "Data/Users/<?php echo $info['dir'] ?>/teepcard.jpg" width = "100%"></div>
</body>
</html>