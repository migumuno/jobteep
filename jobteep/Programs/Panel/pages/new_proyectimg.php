<?php 
$controller = $_SESSION['SO']->getController();
$enum = "proyectimg";
if(isset($_GET['id'])) {
	$controller->setEnum($enum);
	$obj = $controller->selectSingleElement ();
	$MEMO = $obj->getValuesHtml();
	$action = 'updateElement&id='.$_GET['id'];
} else {
	$action = 'insertElement';
	$MEMO = array();
}

$hoy = getdate();
$fecha = $hoy['hours'].$hoy['minutes'].$hoy['seconds'].'_'.$hoy['mday'].$hoy['mon'].$hoy['year'].'_';
$_SESSION['imagePicker'] = $_SESSION['SO']->getUserInfo ('dir');
$_SESSION['nameImg'] = $fecha.$enum;
?>
<div class = "medium-10 medium-offset-1 columns">
	<div class = "row">
		<ul class="breadcrumbs">
		  <li><a href="?program=panel">Inicio</a></li>
		  <li><a href="?program=panel&menu=proyect">Proyectos</a></li>
		  <li><a href="?program=panel&menu=<?php echo $enum ?>&idproy=<?php echo $_GET['idproy']; ?>">Imágenes Proyecto</a></li>
		  <li class="current"><a href="#">Nueva Imagen</a></li>
		</ul>
	</div>
</div>
<div class = "row">
	<div class = "small-10 small-offset-1 columns panel">
		<form data-abide method = "post" action = "?program=panel&menu=proyectimg&idproy=<?php echo $_GET['idproy']; ?>&action=<?php echo $action ?>">
			<fieldset>
			<legend>Datos Principales</legend>
			<div class = "row">
				<div class="medium-12 columns">
			      <label>Título de la imagen <small>requerida</small>
			        <input type = "text" name = "name" placeholder="Título de la imagen" value = "<?php echo $controller->getField ($MEMO, 'name'); ?>" required autocomplete = "off"/>
			      </label>
			      <small class="error">Este campo es necesario.</small>
			    </div>
			</div>
			<div class="row">
			    <div class="medium-12 columns">
			    	<label>Descripción
			    	<textarea rows = "6" name = "description"><?php echo $controller->getField ($MEMO, 'description') ?></textarea>
			    	</label>
			    </div>
			</div>
		  </fieldset><br>
		  <fieldset>
		  <legend>La Imagen</legend>
			<div class = "row">
			  	<div class = "medium-12 columns">
			  		<?php 
					if ($controller->getField ($MEMO, 'file') == '')
						$img_url = $program->getDir().'img/img_bg.png';
					else 
						$img_url = 'Data/Users/'.$_SESSION['SO']->getUserInfo ('dir').'/'.$controller->getField ($MEMO, 'file');
					?>
					<label>Requerido
						<?php 
						if ($img_url != '')
							echo '<img id = "header_img" src = "'.$img_url.'" width = "100%">';
						?>
						<br><br>
						<div class = "row">
							<div class = "medium-6 small-12 columns">
								<a href="#" data-ip-modal="#headerModal" class="button expand">Subir</a>
							</div>
							<div class = "medium-6 small-12 columns">
								<a href = "#" onclick = "document.getElementById('perfil').value = ''; document.getElementById('header_img').src = '<?php echo $program->getDir().'img/img_bg.png' ?>';" class = "button alert expand">Quitar</a>
							</div>
							<input type = "hidden" name = "file" value = "<?php echo $controller->getField ($MEMO, 'file'); ?>" id = "perfil">
						</div>
					</label>
			  	</div>
			  </div>
		  	  </fieldset><br>
			  <div class = "hidden-field"><input type = "hidden" name = "id_proyect" value = "<?php echo $_GET['idproy']; ?>" /></div>
			  <div class = "hidden-field"><input type = "hidden" name = "enum" value = "<?php echo $enum; ?>" /></div>
			  <div class = "medium-12 columns">
				  <button class = "button expand" type="submit">GUARDAR</button>
			  </div>
		</form>
	</div>
</div>