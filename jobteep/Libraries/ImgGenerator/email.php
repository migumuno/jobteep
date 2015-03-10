<?php
header( "Content-type: image/png" );
$txt = $_GET['txt'];
$font_size = 10;
$font = './default.otf';
$ancho = $font_size*strlen($txt);
$alto = 30;
$image = imagecreatetruecolor( $ancho, $alto );

$blanco = imagecolorallocate($image, 255, 255, 255);
$gris = imagecolorallocate($image, 178, 178, 178);
$negro = imagecolorallocate($image, 0, 0, 0);

imagecolortransparent($image, $negro);
imagefttext($image, $font_size, 0, 0, 19, $blanco, $font, $txt);

imagepng($image);
imagedestroy($image);

/*header("Content-type: image/gif");
 
$imagen = imagecreate(300,200);
 
$bgcolor = imagecolorallocate($imagen,230,230,230);
$negro = imagecolorallocate($imagen,0,0,0);
imagecolortransparent($image, $negro);
 
imagesetpixel($imagen,30,30,$negro);
imageline($imagen,30,80,270,80,$negro);
 
imagegif($imagen);
 
imagedestroy($imagen);*/
?>