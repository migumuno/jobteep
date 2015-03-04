<?php 
$controller = $_SESSION['SO']->getController();
$enum = "mtlgeek";
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
		  <li><a href="?program=panel&menu=inspiration">Inspiración</a></li>
		  <li><a href="?program=panel&menu=mtlgeek">Friki</a></li>
		  <li class="current"><a href="#">Nueva Frikada</a></li>
		</ul>
	</div>
</div>
<div class = "row">
	<div class = "small-10 small-offset-1 columns panel">
		<form data-abide method = "post" action = "?program=panel&menu=<?php echo $enum ?>&action=<?php echo $action ?>" enctype="multipart/form-data">
			<div class = "row">
				<div class = "large-4 columns">
					<label>Elige la categoría <small>Requerido</small>
						<input type = "text" list = "categories" name = "category" placeholder="Juegos de rol" value = "<?php echo $controller->getField ($MEMO, 'category') ?>" required autocomplete = "off"/>
					</label>
					<datalist id = "categories">
			        	<?php 
			        	$controller = $_SESSION['SO']->getController();
			        	$result = $controller->getData('geek');
			        	for($i = 0; $i < $result->num_rows; $i++) {
							$result->data_seek($i);
							$row = $result->fetch_assoc();
							echo '<option value = "'.$row['name'].'">';
						}
			        	?>
			        </datalist>
			        <small class="error">Necesitamos saber la categoría.</small>
				</div>
				<div class = "large-8 columns">
					<label>Título <small>requerida</small>
						<input type = "text" name = "title" placeholder="Jugador de World of Warcraft" value = "<?php echo $controller->getField ($MEMO, 'title') ?>" required/>
					</label>
		      		<small class="error">Tienes que ponerle un nombre a tu hobbie.</small>
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