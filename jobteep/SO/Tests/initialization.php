<?php
session_start();

header('Content-Type: text/html; charset=utf-8');


//INICIALIZACIÓN

include_once 'Model/BBDD.class.php';
include_once 'Model/CPU.class.php';
include_once 'Model/MC.class.php';
include_once 'Model/Stack.class.php';
include_once 'Model/Checks/CheckParser.class.php';
include_once 'Model/Elements/ElementParser.class.php';
include_once 'Model/Instructions/InstructionParser.class.php';
include_once 'Model/Collection.class.php';
include_once 'Controllers/PanelController.class.php';

//CREAR LAS UNIDADES PRINCIPALES
$bbdd = new BBDD("panel");
$stack = new Stack();
$mc = new MC();
$cpu = new CPU($bbdd, $stack, $mc);

//OBTENGO EL ID_USER
$id = 1;

//CREO EL CONTROLADOR
$_SESSION['controller'] = new PanelController($cpu, $id);

//INSERTAR LOS PARSER EN EL CONTROLLER
$_SESSION['controller']->setParser(new CheckParser(), "check");
$_SESSION['controller']->setParser(new ElementParser(), "element");
$_SESSION['controller']->setParser(new InstructionParser(), "instruction");

//FIN INICIALIZACIÓN


?>