<?php
header('Content-Type: text/html; charset=UTF-8');
if (isset($_POST['action']))
	$action = $_POST['action'];
else if (isset($_GET['action']))
	$action = $_GET['action'];

switch ($action) {
	case "distance":
		$earth = 6371; //km change accordingly
		//$earth = 3960; //miles
		
		//Point 1 cords
		$lat1 = deg2rad($_POST['ref_lat']);
		$long1= deg2rad($_POST['ref_long']);
		
		//Point 2 cords
		$lat2 = deg2rad($_POST['latitude']);
		$long2= deg2rad($_POST['longitude']);
		
		//Haversine Formula
		$dlong=$long2-$long1;
		$dlat=$lat2-$lat1;
		
		$sinlat=sin($dlat/2);
		$sinlong=sin($dlong/2);
		
		$a=($sinlat*$sinlat)+cos($lat1)*cos($lat2)*($sinlong*$sinlong);
		
		$c=2*asin(min(1,sqrt($a)));
		
		$d=round($earth*$c);
		echo $d;
		break;
}
?>