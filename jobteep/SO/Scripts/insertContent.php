<?php
include '../../Model/BBDD.class.php';

$bbdd = new BBDD ('data');

$name = $_GET['name'];
$enum = $_GET['enum'];

$filename = "../../Docs/'.$name.'.txt";
$file = fopen($filename, 'r');
$sectors = array();
while (!feof($file)) {
	$sectors[] = fgets($file);
}
fclose($file);

print_r($sectors);

$_SESSION['SO']->setBBDD ('DATA');
$from = strtolower($enum);
$fields = array('name');
for ($i = 0; $i < count($sectors); $i++) {
	$values = array($sectors[$i]);
	$bbdd->insert($from, $fields, $values);
}
?>