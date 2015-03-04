<?php 
$controller = $_SESSION['SO']->getController();
$enum = "activity";
if(isset($_GET['id'])) {
	$controller->setEnum($enum);
	$obj = $controller->selectSingleElement ();
	$MEMO = $obj->getValuesHtml();
	$action = 'updateElement&id='.$_GET['id'];
} else {
	$action = 'insertElement';
	if (!isset($MEMO))
		$MEMO = array();
}
?>