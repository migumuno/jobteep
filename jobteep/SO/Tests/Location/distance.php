<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBvb5rGbk9ELMY_XYKViUIW-QyKnJluvu0&sensor=false">
	</script>
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
	<script type="text/javascript">
	
		function getLocation() {
		    if (navigator.geolocation) {
		        navigator.geolocation.getCurrentPosition(showPosition);
		    } else { 
		        x.innerHTML = "Geolocation is not supported by this browser.";
		    }
		}
	
		function showPosition(position) {
			$.ajax({
	            type: "POST",
	            url: "ajax.php",
	            data: {latitude: position.coords.latitude, longitude: position.coords.longitude, ref_lat: 36.721808, ref_long: -4.418033, action: 'distance'},
	            success: function(data) {
					document.getElementById("location").innerHTML = "Tu distancia es: " + data + " km.";
	            }
	        });	
		}
	</script>
</head>
<body onload = "getLocation()">
	<div id = "location"></div>
</body>
</html>