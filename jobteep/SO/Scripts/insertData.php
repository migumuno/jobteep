<?php
include '../../Model/BBDD.class.php';

$bbdd = new BBDD ('data');

/*Education Subsector*/
$from = 'educationsubsector';
$sectors = array ("artes_humanidades", "ciencias_salud", "ciencias", "ingenieria", "ciencias_sociales");

$artes_humanidades = array(
	"Arqueología",
	"Bellas Artes",
	"Conservación y Restauración del Patrimonio Cultural",
	"Diseño",
	"Español: Lengua y Literatura",
	"Estudios Hispano-Alemanes",
	"Estudios Ingleses",
	"Estudios Semíticos e Islámicos",
	"Filología Clásica",
	"Filosofía",
	"Historia",
	"Historia del Arte",
	"Lenguas Modernas y sus Literaturas",
	"Lingüística y Lenguas Aplicados",
	"Literatura General y Comparada",
	"Musicología",
	"Traducción e Interpretación"
);

$fields = 'name, id_educationsector';
$id_educationsector = 1;

for ($i = 0; $i < count($artes_humanidades); $i++) {
	$values = '"'.$artes_humanidades.'", '.$id_educationsector;
	$bbdd->insert ($from, $fields, $values);
}
?>