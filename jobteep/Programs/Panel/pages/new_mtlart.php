<?php 
$controller = $_SESSION['SO']->getController();
$enum = "mtlart";
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
		  <li><a href="?program=panel&menu=mtlart">Arte</a></li>
		  <li class="current"><a href="#">Nueva Obra</a></li>
		</ul>
	</div>
</div>
<div class = "row">
	<div class = "small-10 small-offset-1 columns panel">
		<form data-abide method = "post" action = "?program=panel&menu=<?php echo $enum ?>&action=<?php echo $action ?>" enctype="multipart/form-data">
			<fieldset>
			<legend>Datos Principales</legend>
			<div class = "row">
				<div class = "medium-4 columns">
					<label>Elige la categoría <small>Requerida</small>
						<input type = "text" list = "categories" name = "category" placeholder = "Pintura / Escultura / Fotografía ..." value = "<?php echo $controller->getField ($MEMO, 'category') ?>" required autocomplete = "off"/>
					</label>
					<datalist id = "categories">
			        	<?php 
			        	$controller = $_SESSION['SO']->getController();
			        	$result = $controller->getData('art');
			        	for($i = 0; $i < $result->num_rows; $i++) {
							$result->data_seek($i);
							$row = $result->fetch_assoc();
							echo '<option value = "'.$row['name'].'">';
						}
			        	?>
			        </datalist>
			        <small class="error">Necesitamos saber la categoría.</small>
				</div>
				<div class = "medium-8 columns">
					<label>Título de tu obra <small>requerida</small>
						<input type = "text" name = "title" value = "<?php echo $controller->getField ($MEMO, 'title') ?>" required/>
					</label>
		      		<small class="error">Tienes que ponerle un nombre a tu obra.</small>
				</div>
			</div>
			<div class="row">
			    <div class="medium-12 columns">
			      <label>Descripción
			        <textarea rows = "10" id = "ck_description" name = "description"><?php echo $controller->getField ($MEMO, 'description') ?></textarea>
			      </label>
			    </div>
			</div>
		  </fieldset><br>
		  <fieldset>
		  <legend>Puedes Añadir una Imagen</legend>
			<div class = "row">
			  	<div class = "medium-12 columns">
			  		<?php 
					if ($controller->getField ($MEMO, 'img') == '')
						$img_url = $program->getDir().'img/img_bg.png';
					else 
						$img_url = 'Data/Users/'.$_SESSION['SO']->getUserInfo ('dir').'/'.$controller->getField ($MEMO, 'img');
					?>
					<label>
						<?php 
						if ($img_url != '')
							echo '<img id = "header_img" src = "'.$img_url.'" width = "100%">';
						?>
						<div class = "row">
							<div class = "medium-6 small-12 columns"><a href="#" data-ip-modal="#headerModal" class="button expand">Subir</a></div>
							<div class = "medium-6 small-12 columns"><a href = "#" onclick = "document.getElementById('perfil').value = ''; document.getElementById('header_img').src = '<?php echo $program->getDir().'img/img_bg.png' ?>';" class = "button alert expand">Quitar</a></div>
							<input type = "hidden" name = "img" value = "<?php echo $controller->getField ($MEMO, 'img'); ?>" id = "perfil">
						</div>
					</label>
			  	</div>
			</div>
		  </fieldset><br>
			<div class = "hidden-field"><input type = "hidden" name = "enum" value = "<?php echo $enum; ?>" /></div>
			<div class = "medium-12 columns">
				<button class = "button expand" type="submit">GUARDAR</button>
			</div>
		</form>
	</div>
</div>