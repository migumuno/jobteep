<?php
 
$elementParser = $_SESSION['SO']->getParser('element');
$obj = $elementParser->parser('activity');
$values = array(
	"name" => "",
	"description" => "Esto es un ejemplo del elemento activity."
);
try {
	$obj->setN ($values);
} catch (Exception $e) {
	echo '<br>'.$e->getMessage().'<br>';
}
echo 'Contenido del elemento Activity:<br><br>';
echo 'Nombre: '.$obj->get('name').'<br>';
echo 'Descripción: '.$obj->get('description').'<br>';
?>