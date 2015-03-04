<?php
$controller = $_SESSION['SO']->getController();
$enum = 'language';
if (isset($_GET['break'])) {
	if (isset($_GET['id'])) {
		$action = "?program=panel&menu=new_".$_POST['enum']."&id=".$_GET['id']."&action=insertElement&return=true";
		$return = "?program=panel&menu=new_".$_POST['enum']."&id=".$_GET['id']."&return=true";
	} else {
		$action = "?program=panel&menu=new_".$_POST['enum']."&action=insertElement&return=true";
		$return = "?program=panel&menu=new_".$_POST['enum']."&return=true";
	}
} else {
	if(isset($_GET['id'])) {
		$controller->setEnum($enum);
		$obj = $controller->selectSingleElement ();
		$MEMO = $obj->getValues();
		$action = '?program=panel&menu='.$enum.'&action=updateElement&id='.$_GET['id'];
	} else {
		$action = "?program=panel&menu=".$enum."&action=insertElement";
		$MEMO = array();
	}
	$return = "?program=panel&menu=".$enum;
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
		  <li><a href="?program=panel&menu=language">Idiomas</a></li>
		  <li class="current"><a href="#">Nuevo Idioma</a></li>
		</ul>
	</div>
</div>
<div class = "row">
	<div class = "small-10 small-offset-1 columns panel">
		<form data-abide method = "post" action = "<?php echo $action ?>" enctype="multipart/form-data">
			<fieldset>
			<legend>Datos Principales</legend>
		  <div class="row">
		    <div class="medium-4 columns">
		      <label>Idioma <small>requerida</small>
		        <input type = "text" list = "languages" name = "name" value = "<?php echo $controller->getField ($MEMO, 'name') ?>" placeholder="Nombre del idioma" autofocus required autocomplete = "off"/>
		        <datalist id = "languages">
		        	<?php 
		        	$result = $controller->getData('language');
		        	for($i = 0; $i < $result->num_rows; $i++) {
						$result->data_seek($i);
						$row = $result->fetch_assoc();
						echo '<option value = "'.$row['name'].'">';
					}
		        	?>
		        </datalist>
		      </label>
		      <small class="error">Este campo es necesario.</small>
		    </div>
		    <div class="medium-4 columns">
		    	<label>Nivel
		        <select name = "level">
		          <option value="0" <?php if ($controller->getField ($MEMO, 'level') == 0) echo 'selected' ?>>A2</option>
		          <option value="1" <?php if ($controller->getField ($MEMO, 'level') == 1) echo 'selected' ?>>B1</option>
		          <option value="2" <?php if ($controller->getField ($MEMO, 'level') == 2) echo 'selected' ?>>B2</option>
		          <option value="3" <?php if ($controller->getField ($MEMO, 'level') == 3) echo 'selected' ?>>C1</option>
		          <option value="4" <?php if ($controller->getField ($MEMO, 'level') == 4) echo 'selected' ?>>C2</option>
		        </select>
		      </label>
		    </div>
		    <!-- <div class="medium-4 columns">
		      <label>Certificado
		        <input type = "file" name = "certificate" placeholder="english.pdf">
		      </label>
		    </div> -->
		  </div>
		  <!-- <div class = "row">
		  	<div class="medium-12 columns">
		      <label>La historia
		        <textarea rows = "10" id = "ck_description" name = "story"><?php /*echo $controller->getField ($MEMO, 'story')*/ ?></textarea>
		      </label>
		    </div>
		  </div>
		  <br> -->
		  </fieldset><br>
		  <fieldset>
		  <legend>Puedes Añadir un Certificado</legend>
		  <div class = "row">
		  	<div class = "medium-12 columns">
		  		<?php 
				if ($controller->getField ($MEMO, 'certificate') == '')
					$img_url = $program->getDir().'img/img_bg.png';
				else 
					$img_url = 'Data/Users/'.$_SESSION['SO']->getUserInfo ('dir').'/'.$controller->getField ($MEMO, 'certificate');
				?>
				<label>
					<img id = "header_img" src = "<?php echo $img_url; ?>" width = "100%">
					<div class = "row">
						<div class = "medium-6 small-12 columns"><a href="#" data-ip-modal="#headerModal" class="button expand">Subir</a></div>
						<div class = "medium-6 small-12 columns"><a href = "#" onclick = "document.getElementById('perfil').value = ''; document.getElementById('header_img').src = '<?php echo $program->getDir().'img/img_bg.png' ?>';" class = "button alert expand">Quitar</a></div>
						<input type = "hidden" name = "certificate" value = "<?php echo $controller->getField ($MEMO, 'certificate'); ?>" id = "perfil">
					</div>
				</label>
		  	</div>
		  </div>
		  </fieldset><br>
		  <div class = "hidden-field"><input type = "hidden" name = "enum" value = "language" /></div>
		  <div class = "medium-12 columns">
			  <button class = "button expand" type="submit">GUARDAR</button>
		  </div>
		</form>
	</div>
</div>
