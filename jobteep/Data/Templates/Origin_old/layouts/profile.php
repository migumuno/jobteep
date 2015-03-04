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
    <link href="http://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Shadows+Into+Light' rel='stylesheet' type='text/css'>
    <script src="Libraries/foundation/js/vendor/modernizr.js"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/cupertino/jquery-ui.css " />
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
	<script src="http://d3js.org/d3.v3.min.js"></script>
	<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBvb5rGbk9ELMY_XYKViUIW-QyKnJluvu0&sensor=false"></script>
	<script>
		function initialize() {
			var mapProp = {
			  center:new google.maps.LatLng(34.2556617,5.992691),
			  zoom:2,
			  mapTypeId:google.maps.MapTypeId.TERRAIN
			  };
	
			var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
	
			/*Marcadores*/
			<?php
			if($info['address'] != '' && !is_null($info['address'])) {
				$controller->printMarker ($info['address'], 'Donde vivo', 4);
			}
			$enum = 'travel';
			$controller->setEnum($enum);
			$order = 'start_date DESC';
			$travel = $controller->selectAllElements($UID, $order);
			for ($i = 0; $i < $travel->num_rows; $i++) {
				$travel->data_seek($i);
				$row = $travel->fetch_assoc();
				$controller->printMarker ($row['location'], $row['title'], $row['type']);
			}
			?>
		}
		
		google.maps.event.addDomListener(window, 'load', initialize);
	</script>
</head>
<body>
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