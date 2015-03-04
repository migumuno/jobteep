<?php
$controller = $_SESSION['SO']->getController();
$enum = 'skill';
if (isset($_GET['break'])) {
	if (isset($_GET['id'])) {
		$action = "?program=panel&menu=new_".$_POST['enum']."&id=".$_GET['id']."&action=insertElement&return=true";
		$return = "?program=panel&menu=new_".$_POST['enum']."&id=".$_GET['id']."&return=true";
		$MEMO = array();
	} else {
		$action = "?program=panel&menu=new_".$_POST['enum']."&action=insertElement&return=true";
		$return = "?program=panel&menu=new_".$_POST['enum']."&return=true";
		$MEMO = array();
	}
} else {
	if(isset($_GET['id'])) {
		$controller->setEnum($enum);
		$obj = $controller->selectSingleElement ();
		$MEMO = $obj->getValuesHtml();
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
		  <li><a href="?program=panel&menu=skill">Aptitudes</a></li>
		  <li class="current"><a href="#">Nueva Aptitud</a></li>
		</ul>
	</div>
</div>
<div class = "row">
	<div class = "small-10 small-offset-1 columns panel">
		<form data-abide method = "post" action = "<?php echo $action ?>" enctype="multipart/form-data">
			<fieldset>
			<legend>Datos Principales</legend>
		  <div class="row">
		    <div id = "apt_def" class="medium-4 columns">
		      <label>Aptitud <small>requerida</small>
		        <input type = "text" list = "skills" name = "name" value = "<?php echo $controller->getField ($MEMO, 'name') ?>" placeholder="Nombre de la aptitud" required autocomplete = "off"/>
		        <datalist id = "skills">
		        	<?php 
		        	$result = $controller->getData('skill');
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
		    <div class="medium-2 columns">
		    	<label>Nivel
		        <select name = "level">
		          <option value="0" <?php if ($controller->getField ($MEMO, 'level') == 0) echo 'selected' ?>>Aprendiz</option>
		          <option value="1" <?php if ($controller->getField ($MEMO, 'level') == 1) echo 'selected' ?>>Junior</option>
		          <option value="2" <?php if ($controller->getField ($MEMO, 'level') == 2) echo 'selected' ?>>Especialista</option>
		          <option value="3" <?php if ($controller->getField ($MEMO, 'level') == 3) echo 'selected' ?>>Maestro</option>
		          <option value="4" <?php if ($controller->getField ($MEMO, 'level') == 4) echo 'selected' ?>>Gurú</option>
		        </select>
		      </label>
		    </div>
		    <div class="medium-2 columns">
		      <label>Autodidacta
		        <select name = "self">
		          <option value="0" <?php if ($controller->getField ($MEMO, 'self') == 0) echo 'selected' ?>>NO</option>
		          <option value="1" <?php if ($controller->getField ($MEMO, 'self') == 1) echo 'selected' ?>>SI</option>
		        </select>
		      </label>
		    </div>
		    <div class = "medium-4 columns">
		    	<label>Sector <small>requerido</small>
		  			<select name = "sector" >
		  				<option value = "none">...</option>
		  				<?php 
			        	$controller = $_SESSION['SO']->getController();
			        	$result = $controller->getData('sector');
			        	for($i = 0; $i < $result->num_rows; $i++) {
							$result->data_seek($i);
							$row = $result->fetch_assoc();
							echo '<option value = "'.$row['id_sector'].'"'; if ($controller->getField ($MEMO, 'sector') == $row['id_sector']) echo ' selected'; echo '>'.$row['name'].'</option>';
						}
			        	?>
		  			</select>
		  		</label>
		    </div>
		  </div>
		  <!-- <div class = "row">
		  	<div class="medium-12 columns">
		      <label>La historia
		        <textarea rows = "10" id = "ck_description" name = "story" placeholder=""><?php /*echo $controller->getField ($MEMO, 'story')*/ ?></textarea>
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
					<?php 
					if ($img_url != '')
						echo '<img id = "header_img" src = "'.$img_url.'" width = "100%">';
					?>
					<div class = "row">
						<div class = "medium-6 small-12 columns"><a href="#" data-ip-modal="#headerModal" class="button expand">Subir</a></div>
						<div class = "medium-6 small-12 columns"><a href = "#" onclick = "document.getElementById('perfil').value = ''; document.getElementById('header_img').src = '<?php echo $program->getDir().'img/img_bg.png' ?>';" class = "button alert expand">Quitar</a></div>
						<input type = "hidden" name = "certificate" value = "<?php echo $controller->getField ($MEMO, 'certificate'); ?>" id = "perfil">
					</div>
				</label>
		  	</div>
		  </div>
		  </fieldset><br>
		  <div class = "hidden-field"><input type = "hidden" name = "enum" value = "skill" /></div>
		  <div class = "medium-12 columns">
			  <button class = "button expand" type="submit">GUARDAR</button>
		  </div>
		</form>
	</div>
</div>
