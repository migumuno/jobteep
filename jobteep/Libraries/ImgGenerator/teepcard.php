<?php
session_start();
header( "Content-type: image/png" );

//VARIABLES
$font_size = 200;
$nombre = $_SESSION['teepcard']['nombre'];
$apellidos = explode(' ', $_SESSION['teepcard']['apellido']);
$margin = array(
	"left" => "200",
	"top" => "400"	
);
$distance = 2440;
$width = 2700;
$height = 3500;
$font = './Sawasdee-Bold.ttf';

//CREACIÓN DE IMAGEN
$image = imagecreate($width, $height);
$bg_color = imagecolorallocate($image, 201, 212, 111);

//IMAGEN DE FONDO
/*$bg = imagecreatefromjpeg('./fondo_teepcard.jpg');
imagecopy($image, $bg, 0, 0, 0, 0, imagesx($bg), imagesy($bg));*/

//COLORES
$negro = imagecolorallocate($image, 0, 0, 0);
$jobteep_dark = imagecolorallocate($image, 76, 76, 76);
$blanco = imagecolorallocate($image, 255, 255, 255);
$gris = imagecolorallocate($image, 168, 168, 168);

//TEXTOS
$text_color = $jobteep_dark;
//Nombre
imagefttext($image, $font_size, 0, $margin['left'], $margin['top'], $text_color, $font, $nombre);
imagefttext($image, $font_size, 0, $margin['left'], $margin['top']*2, $text_color, $font, $apellidos[0]);
imagefttext($image, $font_size, 0, $margin['left'], $margin['top']*3, $text_color, $font, $apellidos[1]);
//Profesión
$font_size = 80;
$profesion = $_SESSION['teepcard']['profesion'];
imagefttext($image, $font_size, 0, $margin['left'], $distance, $text_color, $font, strtr(strtoupper($profesion), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"));
//Email
$email = 'E: '.$_SESSION['teepcard']['email'];
imagefttext($image, $font_size, 0, $margin['left'], $distance + 180, $text_color, $font, $email);
//Jobteep
$jobteep = 'J: /'.$_SESSION['teepcard']['dominio'];
imagefttext($image, $font_size, 0, $margin['left'], $distance + (180*2), $text_color, $font, $jobteep);
//Teléfono
$telf = 'T: '.$_SESSION['teepcard']['telf'];
imagefttext($image, $font_size, 0, $margin['left'], $distance + (180*3), $text_color, $font, $telf);
//Jobteep url
$telf = 'www.jobteep.com';
$font_size = 60;
$pos = ($width/2) - 339;
imagefttext($image, $font_size, 0, $pos, $distance + (180*5), $blanco, $font, $telf);

//IMPRESIÓN DE IMAGEN
imagepng($image);
imagedestroy($image);
?>