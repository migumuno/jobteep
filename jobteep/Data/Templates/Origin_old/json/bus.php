<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
$json = $_SESSION['brain'];
print_r($json);
?>