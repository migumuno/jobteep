<?php 
$controller = $_SESSION['SO']->getController();
$enum = "forum";
if(isset($_GET['id'])) {
	$controller->setEnum($enum);
	$obj = $controller->selectSingleElement ();
	$MEMO = $obj->getValuesHtml();
	$action = 'updateElement&id='.$_GET['id'];
} else {
	$action = 'insertElement';
	$MEMO = array();
}
?>
<div class = "large-10 large-offset-1 columns">
	<div class = "row">
		<ul class="breadcrumbs">
		  <li><a href="?program=panel">Inicio</a></li>
		  <li><a href="?program=panel&menu=publications">Publicaciones</a></li>
		  <li><a href="?program=panel&menu=forum">Foros</a></li>
		  <li class="current"><a href="#">Nuevo Foro</a></li>
		</ul>
	</div>
</div>
<div class = "row">
	<div class = "small-10 small-offset-1 columns panel">
		<form data-abide method = "post" action = "?program=panel&menu=<?php echo $enum ?>&action=<?php echo $action ?>" enctype="multipart/form-data">
			<div class = "row">
				<div class="large-4 columns">
				    <label>Nombre de usuario en el foro <small>Requerido</small>
				      <input type="text" name = "user" value = "<?php echo $controller->getField ($MEMO, 'user') ?>" placeholder="diegoFoto" required/>
				    </label>
			    </div>
				<div class = "large-8 columns">
					<label>Nombre del foro <small>requerida</small>
						<input type = "text" name = "name" placeholder="Foro Foto" value = "<?php echo $controller->getField ($MEMO, 'name') ?>" required/>
					</label>
		      		<small class="error">Tienes que indicar el nombre del foro.</small>
				</div>
			</div>
			<div class = "row">
				<div class = "large-4 columns">
			  		<label>Temática principal <small>Importante</small>
			  			<select name = "sector1">
			  				<option value = "none">...</option>
			  				<?php 
				        	$controller = $_SESSION['SO']->getController();
				        	$result = $controller->getData('sector');
				        	for($i = 0; $i < $result->num_rows; $i++) {
								$result->data_seek($i);
								$row = $result->fetch_assoc();
								echo '<option value = "'.$row['id_sector'].'"'; if ($controller->getField ($MEMO, 'sector1') == $row['id_sector']) echo ' selected'; echo '>'.$row['name'].'</option>';
							}
				        	?>
			  			</select>
			  		</label>
			  	</div>
			  	<div class = "large-4 columns">
			  		<label>Temática Secundaria <small>Importante</small>
			  			<select name = "sector2">
			  				<option value = "none">...</option>
			  				<?php 
				        	$controller = $_SESSION['SO']->getController();
				        	$result = $controller->getData('sector');
				        	for($i = 0; $i < $result->num_rows; $i++) {
								$result->data_seek($i);
								$row = $result->fetch_assoc();
								echo '<option value = "'.$row['id_sector'].'"'; if ($controller->getField ($MEMO, 'sector2') == $row['id_sector']) echo ' selected'; echo '>'.$row['name'].'</option>';
							}
				        	?>
			  			</select>
			  		</label>
			  	</div>
			</div>
			<div class = "row">
				<div class = "large-12 columns">
					<label>URL <small>Requerido</small>
						<input type = "text" name = "url" placeholder="www.elblogdelfotografo.es" value = "<?php echo $controller->getField ($MEMO, 'url') ?>" required/>
					</label>
				</div>
			</div>
			<div class="row">
			    <div class = "large-4 columns">
			    	<label>¿En cuántos temas diferentes has participado? <small>Importante</small>
			    		<input type = "number" name = "themes" placeholder = "6" value = "<?php echo $controller->getField ($MEMO, 'themes') ?>">
			    	</label>
			    </div>
			</div>
			<div class="row">
			    <div class="large-12 columns">
			      <label>Descripción
			        <textarea rows = "10" id = "ck_description" name = "description"><?php echo $controller->getField ($MEMO, 'description') ?></textarea>
			      </label>
			    </div>
			</div>
			<br>
			<input type = "hidden" name = "enum" value = "<?php echo $enum; ?>" />
			<div class = "large-12 columns">
				<button class = "button success expand" type="submit">GUARDAR</button>
			</div>
		</form>
	</div>
</div>