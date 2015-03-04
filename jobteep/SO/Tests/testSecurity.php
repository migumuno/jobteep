<?php
$register = array(
	'user' => 'cuellar.pa@gmail.com',
	'pass' => '1234',
	'pass2' => '1234'
);

$login = array(
	'user' => 'cuellar.pa@gmail.com',
	'pass' => 'gusanillo'
);

$key = '$2a$07$l2Vxu4Jj0kkO19gsDrq6luAD731WPHp/cHS4DO/sFAaBJ8E6azYoe';

$user = 'cuellar.pa@gmail.com';

$pass = 'gusanillo';
$pass2 = 'gusanillo';

$_SESSION['SO']->openProgram();

$_SESSION['SO']->register($register);
/*$_SESSION['SO']->login($login);
$_SESSION['SO']->confirmEmail($key);
$_SESSION['SO']->passRecover($user);
$_SESSION['SO']->changePass($key, $pass, $pass2);*/
?>