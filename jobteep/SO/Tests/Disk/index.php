<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Pruebas Multimedia</title>
<script type="text/javascript">
	function select (archivo) {
		document.getElementById("selected").innerHTML = archivo;
	}
</script>
</head>
<body>
<?php
$dir = "archivos/miguelamv11@gmail.com/";

//CREAR DIRECTORIO
/*mkdir("archivos/miguelamv11@gmail.com", 0775);*/

//MOSTRAR ARCHIVOS DEL DIRECTORIO
$directory = opendir($dir);
while ($archivo = readdir($directory)) { 
  	if(($archivo != '.') && ($archivo != '..') && !is_dir("$dir/$archivo")) {
    	echo '
    		<a href = "#" onclick = "select(\''.$archivo.'\');">
	    		<img src = "'.$dir.$archivo.'" width = "200px">
	    		<h1>'.$archivo.'</h1>
	    	</a>
    	';
  	}
}
closedir($directory);

//ELIMINAR ARCHIVO
/*unlink($dir.'metro.png');*/
?>
<div id = "selected"></div>
</body>
</html>