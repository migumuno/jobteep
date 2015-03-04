<?php
if (isset($_GET['destacado']))
	include 'Data/Templates/'.$_GET['template'].'/forms/destacados.php';
else
	include 'Data/Templates/'.$_GET['template'].'/form.php';
?>