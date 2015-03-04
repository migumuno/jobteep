<?php
$filename = "Docs/Universidades.txt";
$file = fopen($filename, 'r');
$centers = array();
while (!feof($file)) {
	$centers[] = fgets($file);
}
fclose($file);

$_SESSION['SO']->setBBDD ('DATA');
$from = 'center';
$fields = array('name');
for ($i = 0; $i < count($centers); $i++) {
	$values = array($centers[$i]);
	$_SESSION['SO']->insert($from, $fields, $values);
}
?>