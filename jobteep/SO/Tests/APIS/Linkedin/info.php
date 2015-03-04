<?php
// Fill the keys and secrets you retrieved after registering your app
$oauth = new OAuth("77i0wrm327h22q", "3ly63wlJMZidyHMn");
$oauth->setToken("5c15d222-63a8-422e-8aef-18daefe1cbca", "3a688cee-f174-49d2-9e36-195f73ac76d9");
 
$params = array();
$headers = array();
$method = OAUTH_HTTP_METHOD_GET;
  
// Specify LinkedIn API endpoint to retrieve your own profile
$url = "https://api.linkedin.com/v1/people/~";
 
// By default, the LinkedIn API responses are in XML format. If you prefer JSON, simply specify the format in your call
// $url = "https://api.linkedin.com/v1/people/~?format=json";
 
// Make call to LinkedIn to retrieve your own profile
$oauth->fetch($url, $params, $method, $headers);
  
echo $oauth->getLastResponse();
?>