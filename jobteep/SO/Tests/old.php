<?php 
session_start();

define('PANELVIEW', 'panelView');
define('WEBVIEW', 'webView');
define('TEMPLATEVIEW', 'templateView');

header('Content-Type: text/html; charset=utf-8');
include_once 'SO/Main.class.php';

include_once 'SO/Security/Security.class.php';

$MAIN = new Main();
$MAIN->start();
if ($_SESSION['Security']->checkAccess()) {
	$_SESSION['Security']->setView(Main::$CURRENT_VIEW);
	$page = $_SESSION[Main::$CURRENT_VIEW]->printPage($_GET['menu']);
} else {
	$_SESSION['Security']->setView(WEBVIEW);
	$page = $_SESSION[Main::$CURRENT_VIEW]->printPage('login');
	echo "<script type='text/javascript'>alert('¡Permiso denengado! Está intentando acceder a un área restringida sin previa autorización.');</script>";
}
	
include $page;

?>