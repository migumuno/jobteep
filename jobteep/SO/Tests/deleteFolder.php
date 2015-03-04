<?php
/*$carpeta  = "www.jobteep.com/Data/Users/1/";
eliminarDir($carpeta);

function eliminarDir($carpeta) {
	foreach(glob($carpeta . "/*") as $archivos_carpeta) {
		echo $archivos_carpeta;
	 
		if (is_dir($archivos_carpeta)) {
			eliminarDir($archivos_carpeta);
		}
		else
			unlink($archivos_carpeta);
	}
	 
	rmdir($carpeta);
}*/
$dirname = 'http://www.jobteep.com/Data/Users/1/images';
chown($dirname,'jobfeel');