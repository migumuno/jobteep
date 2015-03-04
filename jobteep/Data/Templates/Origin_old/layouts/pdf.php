<?php 
$controller = $_SESSION['SO']->getController();
$info = $controller->getUserInfo();
$UID = $info['id_user'];
include $program->getDir() . $program->getInfo('content');
?>