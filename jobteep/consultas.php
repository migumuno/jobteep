<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();

switch ($_POST['action']) {
	case "proyect":
		$proyect = $_SESSION['proyectos'][$_POST['id_proyect']];
		include $_POST['dir'].'pages/proyect.php';
		break;
}
?>