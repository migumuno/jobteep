<?php
$enum = strtolower($_GET['template']);
$destacados = array("", "izquierda", "centro", "derecha");
$controller = $_SESSION['SO']->getController();
$controller->setEnum($enum);
$collection = $controller->selectTemplate ();
$_SESSION['SO']->setBBDD('PANEL');
$template_array = $collection->getArray();
foreach ($template_array as $k => $v) {
	$template = $v;
}
$_SESSION['imagePicker'] = $_SESSION['SO']->getUserInfo ('dir');
$_SESSION['nameImg'] = $enum.'_destacado_'.$destacados[$_GET['destacado']];
?>
<div class = "large-10 large-offset-1 columns">
	<div class = "row">
		<ul class="breadcrumbs">
		  <li><a href="?program=panel">Inicio</a></li>
		  <li><a href="?program=panel&menu=settings">Settings</a></li>
		  <li><a href="?program=panel&menu=template&template=<?php echo $_GET['template'] ?>">Configuración plantilla</a></li>
		  <li class="current"><a href="#">Destacado <?php echo $destacados[$_GET['destacado']] ?></a></li>
		</ul>
	</div>
</div>
<div class = "row">
	<form name = "Intro" data-abide method = "post" action = "?program=panel&menu=template&template=<?php echo $_GET['template'] ?>&action=configTemplate&id=<?php echo $template->getId(); ?>" enctype="multipart/form-data">
		<div class = "medium-10 medium-offset-1 columns panel">
			<?php if ($_GET['destacado'] == 3) { ?>
				<div class = "row">
					<div class = "medium-4 columns">
						<label>¿Qué quieres mostrar?
			  			<select name = "typeD3">
			  				<?php 
			  				$answer = array("Imagen", "Video");
			  				for ($i = 0; $i < count($answer); $i++){
								echo '<option value = "'.$i.'"'; if ($template->get('typeD3') == $i) echo ' selected'; echo '>'.$answer[$i].'</option>';
							}
			  				?>
			  			</select>
			  		</label>
					</div>
				</div>
				<div class = "row">
					<div class = "large-12 columns">
						<h3>VIDEO</h3>
					</div>
				</div>
				<div class = "row">
					<div class = "medium-12 columns">
						<label>Identificador Youtube (Lo que está en la URL detrás de la v=)
							<input type = "text" name = "videoD<?php echo $_GET['destacado'] ?>" placeholder = "Ejemplo -> X9V1C5AVKGY" value = "<?php echo $template->get('videoD'.$_GET['destacado']); ?>">
						</label>
					</div>
				</div>
			<?php } ?>
			<div class = "row">
				<div class = "large-12 columns">
					<h3>IMAGEN</h3>
				</div>
			</div>
			<div class = "row">
				<div class = "medium-4 columns">
					<label>Texto destacado
						<input type = "text" name = "txtD<?php echo $_GET['destacado'] ?>" value = "<?php echo $template->get('txtD'.$_GET['destacado']); ?>">
					</label>
				</div>
			</div>
			<div class = "row">
				<div class = "medium-4 columns">
			  		<?php 
					if ($template->get('imgD'.$_GET['destacado']) == '' || is_null($template->get('imgD'.$_GET['destacado'])))
						$img_url = 'Data/Templates/'.$_GET['template'].'/img/'.$_GET['destacado'].'.jpg';
					else 
						$img_url = 'Data/Users/'.$_SESSION['SO']->getUserInfo ('dir').'/'.$template->get('imgD'.$_GET['destacado']);
					?>
					<label><h3>Fondo Destacado</h3>
						<span id = "img_bg">
							<img id = "header_img" src = "<?php echo $img_url; ?>" width = "100%">
						</span>
						<div class = "row">
							<br>
							<a href="#" data-ip-modal="#headerModal" class="button">Subir</a>
							<a onclick = "document.getElementById('perfil').value = ''; document.getElementById('header_img').src = '<?php echo 'Data/Templates/'.$_GET['template'].'/img/'.$_GET['destacado'].'.jpg' ?>';" class = "button alert">Quitar</a>
							<input type = "hidden" name = "imgD<?php echo $_GET['destacado'] ?>" value = "<?php echo $template->get('imgD'.$_GET['destacado']); ?>" id = "perfil">
						</div>
					</label>
			  	</div>
			</div>
			<br>
			<input type = "hidden" name = "enum" value = "<?php echo $enum ?>" />
			<div class = "medium-12 columns">
				<button class = "button expand" type="submit">GUARDAR</button>
			</div>
		</div>
	</form>
</div>