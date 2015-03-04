<?php
$enum = "origin";
$controller = $_SESSION['SO']->getController();
$controller->setEnum($enum);
$collection = $controller->selectTemplate ();
$_SESSION['SO']->setBBDD('PANEL');
$template_array = $collection->getArray();
foreach ($template_array as $k => $v) {
	$template = $v;
}
$_SESSION['imagePicker'] = $_SESSION['SO']->getUserInfo ('dir');
$_SESSION['nameImg'] = $enum.'_template';
?>
<div class = "row">
	<div class = "small-10 small-offset-1 columns">
		<div class = "large-3 columns"><a href="?program=panel&menu=settings" class="button"><img src = "<?php echo $program->getDir() ?>img/return.png" width = "20px;"> VOLVER</a></div>
		<div class = "large-6 columns"><h1 class = "subheader text-center">Configuración de Plantilla</h1></div>
		<div class = "large-3 columns"></div>
	</div>
</div>
<div class = "row">
	<form name = "Intro" data-abide method = "post" action = "?program=panel&menu=settings&action=configTemplate&id=<?php echo $template->getId(); ?>" enctype="multipart/form-data">
	<div class = "large-10 large-offset-1 columns panel">
		<p><img alt="The Jobfeel" src="Programs/Panel/img/question.png" width = "20px"> <small>Recomendamos una proporción de 5,33. Ej: 1600*300.</small></p>
		<div class = "row">
			<div class = "large-12 columns">
		  		<?php 
				if ($template->get('header_img') == '' || is_null($template->get('header_img')))
					$img_url = '';
				else 
					$img_url = 'Data/Users/'.$_SESSION['SO']->getName().'/'.$template->get('header_img');
				?>
				<label>Elige la imagen de cabecera
					<img id = "header_img" src = "<?php echo $img_url; ?>" width = "100%">
					<div class = "row">
						<a href="#" data-ip-modal="#headerModal" class="button expand">Subir</a>
						<input type = "hidden" name = "header_img" value = "<?php echo $template->get('header_img'); ?>" id = "perfil">
					</div>
				</label>
		  	</div>
		</div>
		<br>
		<input type = "hidden" name = "enum" value = "<?php echo $enum ?>" />
		<div class = "large-12 columns">
			  <button class = "button success expand" type="submit">GUARDAR</button>
		  </div>
	 	<?php 
			if (SO::$ALERT) {
				echo '<div data-alert class="alert-box info radius">
					'.SO::$MESSAGE.'
				  <a href="#" class="close">&times;</a>
				</div>';
			}
		?>
	</div>
	</form>
</div>