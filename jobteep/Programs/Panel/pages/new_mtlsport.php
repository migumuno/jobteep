<?php 
$controller = $_SESSION['SO']->getController();
$enum = "mtlsport";
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
<div class = "medium-10 medium-offset-1 columns">
	<div class = "row">
		<ul class="breadcrumbs">
		  <li><a href="?program=panel">Inicio</a></li>
		  <li><a href="?program=panel&menu=mtlsport">Deportes</a></li>
		  <li class="current"><a href="#">Nuevo Deporte</a></li>
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
					<label>Elige la categoría <small>Requerido</small>
						<input type = "text" list = "categories" name = "category" placeholder="Running / Escalada / Fútbol ..." value = "<?php echo $controller->getField ($MEMO, 'category') ?>" required autocomplete = "off"/>
					</label>
					<datalist id = "categories">
			        	<?php 
			        	$controller = $_SESSION['SO']->getController();
			        	$result = $controller->getData('sport');
			        	for($i = 0; $i < $result->num_rows; $i++) {
							$result->data_seek($i);
							$row = $result->fetch_assoc();
							echo '<option value = "'.$row['name'].'">';
						}
			        	?>
			        </datalist>
			        <small class="error">Necesitamos saber la categoría.</small>
				</div>
				<div class = "medium-4 columns">
					<label>Frecuencia <small>requerido</small>
						<select name = "frequency">
			  				<?php 
			  				$frequencies = array("Diaria", "6-4 v/s", "3-2 v/s", "1 v/s", "1 v/q", "1 v/m", "Otro");
							for ($i = 0; $i < count($frequencies); $i++) {
								echo '<option value = "'.$i.'" ';
								if ($controller->getField ($MEMO, 'frequency') == $i) echo ' selected';
								echo '>'.$frequencies[$i].'</option>';
							}
			  				?>
			  			</select>
					</label>
				</div>
				<input type = "hidden" name = "level" value = "0" />
			</div>
			</fieldset><br>
			<!-- <div class="row">
			    <div class="medium-12 columns">
			      <label>Descripción
			        <textarea rows = "10" id = "ck_description" name = "description"><?php /*echo $controller->getField ($MEMO, 'description')*/ ?></textarea>
			      </label>
			    </div>
			</div>
			<br> -->
			<div class = "hidden-field"><input type = "hidden" name = "enum" value = "<?php echo $enum; ?>" /></div>
			<div class = "medium-12 columns">
				<button class = "button expand" type="submit">GUARDAR</button>
			</div>
		</form>
	</div>
</div>