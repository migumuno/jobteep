<?php
/*header( "Content-type: image/png" );
$ancho = 200;
$font = 'Libraries/fonts/HelveticaNeueLTPro-L.otf';
$alto = 30;
$image = imagecreate( $ancho, $alto );
$blanco = imagecolorallocate($image, 255, 255, 255);
$negro = imagecolorallocate($image, 0, 0, 0);
imagettftext($image, 16, 0, 10, 20, $negro, $font, $_GET['txt']);

imagepng($image);
imagedestroy($image);*/

header("Content-type: image/gif");
 
$imagen = imagecreate(300,200);
 
$bgcolor = imagecolorallocate($imagen,230,230,230);
$negro = imagecolorallocate($imagen,0,0,0);
 
imagesetpixel($imagen,30,30,$negro);
imageline($imagen,30,80,270,80,$negro);
 
imagegif($imagen);
 
imagedestroy($imagen);
?>