<?php 
header('Content-Type: text/html; charset=UTF-8');
include_once 'SO/SO.class.php';
session_start();

/*session_unset();
session_destroy();
session_start();
session_regenerate_id(true);*/

if (!isset($_SESSION['SO'])) {
	$_SESSION['SO'] = new SO();
	$_SESSION['SO']->start();
}
$program = $_SESSION['SO']->openProgram();

if (isset($_GET['action'])) {
	$controller = $_SESSION['SO']->getController();
	if (isset($_POST['enum']))
		$controller->setEnum($_POST['enum']);
	$controller->executeAction();
}

if (isset($_GET['break']) && $_GET['break'] == "true") {
	$controller = $_SESSION['SO']->getController();
	$controller->save();
}

if (isset($_GET['return']) && $_GET['return'] == "true") {
	$controller = $_SESSION['SO']->getController();
	$MEMO = $controller->load();
}

include $program->printPage();

/*include 'SO/Scripts/insertSectors.php';*/
?>