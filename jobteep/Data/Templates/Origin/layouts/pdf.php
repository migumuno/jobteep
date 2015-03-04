<?php 
header('Content-Type: text/html; charset=UTF-8');
$controller = $_SESSION['SO']->getController();
$info = $controller->getUserInfo();
$UID = $info['id_user'];
$controller->setUID ($UID);
$controller->setUser ($info['user']);
$controller->setVersion ($info['version']);
$trabajos = $controller->trabajos();
$formacion = $controller->formacion();
$proyectos = $controller->proyectos();
$aptitudes = $controller->aptitudes();
$idiomas = $controller->idiomas();
$upgrade = $controller->getUpgrade ();
include $program->getDir() . $program->getInfo('content');
?>