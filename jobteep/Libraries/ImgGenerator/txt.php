<?php
header("Content-Type: image/png");
$font = 20;
$string = $_GET['txt'];
 $im = @imagecreatetruecolor(strlen($string) * $font / 1.5, $font);
    imagesavealpha($im, true);
    imagealphablending($im, false);
    $white = imagecolorallocatealpha($im, 255, 255, 255, 127);
    imagefill($im, 0, 0, $white);
    $lime = imagecolorallocate($im, 204, 255, 51);
    imagettftext($im, $font, 0, 0, $font - 3, $lime, "droid_mono.ttf", $string);
    header("Content-type: image/png");
    imagepng($im);
    imagedestroy($im);
?>