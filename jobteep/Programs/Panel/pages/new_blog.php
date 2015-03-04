<?php 
$controller = $_SESSION['SO']->getController();
$enum = "blog";
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
<div class = "large-10 large-offset-1 columns">
	<div class = "row">
		<ul class="breadcrumbs">
		  <li><a href="?program=panel">Inicio</a></li>
		  <li><a href="?program=panel&menu=publications">Publicaciones</a></li>
		  <li><a href="?program=panel&menu=blog">Blogs</a></li>
		  <li class="current"><a href="#">Nuevo Blog</a></li>
		</ul>
	</div>
</div>
<div class = "row">
	<div class = "small-10 small-offset-1 columns panel">
		<form data-abide method = "post" action = "?program=panel&menu=<?php echo $enum ?>&action=<?php echo $action ?>" enctype="multipart/form-data">
			<div class = "row">
				<div class="large-4 columns">
				    <label>Visitas mensuales
				      <input type="number" name = "month_views" value = "<?php echo $controller->getField ($MEMO, 'month_views') ?>" placeholder="1000" />
				    </label>
			    </div>
				<div class = "large-8 columns">
					<label>Nombre del blog <small>requerida</small>
						<input type = "text" name = "name" placeholder="El blog del fotógrafo" value = "<?php echo $controller->getField ($MEMO, 'name') ?>" required/>
					</label>
		      		<small class="error">Tienes que ponerle un nombre a tu artículo.</small>
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
			  	<div class = "large-4 columns">
			  		<label>Temática Terciaria <small>Importante</small>
			  			<select name = "sector3">
			  				<option value = "none">...</option>
			  				<?php 
				        	$controller = $_SESSION['SO']->getController();
				        	$result = $controller->getData('sector');
				        	for($i = 0; $i < $result->num_rows; $i++) {
								$result->data_seek($i);
								$row = $result->fetch_assoc();
								echo '<option value = "'.$row['id_sector'].'"'; if ($controller->getField ($MEMO, 'sector3') == $row['id_sector']) echo ' selected'; echo '>'.$row['name'].'</option>';
							}
				        	?>
			  			</select>
			  		</label>
			  	</div>
			</div>
			<div class = "row">
				<div class = "large-12 columns">
					<label>URL
						<input type = "text" name = "url" placeholder="www.elblogdelfotografo.es" value = "<?php echo $controller->getField ($MEMO, 'url') ?>"/>
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
			<div class="row">
			    <div class="large-4 columns">
			      <label>Fecha de creación
			      	<?php 
					if ($controller->getField ($MEMO, 'start_date') == '0000-00-00')
						$MEMO['start_date'] = '';
					if ($controller->getField ($MEMO, 'end_date') == '0000-00-00')
						$MEMO['end_date'] = '';
			      	?>
			        <input type="text" name = "start_date" id = "dp1" value = "<?php echo $controller->getField ($MEMO, 'start_date') ?>" placeholder="aaaa/mm/dd" />
			      </label>
			    </div>
			    <div class="large-4 columns">
			      <label>Fecha de cierre
			        <input type="text" name = "end_date" id = "dp2" value = "<?php echo $controller->getField ($MEMO, 'end_date') ?>" placeholder="aaaa/mm/dd" />
			      </label>
			    </div>
			</div>
			<div class = "row">
			  	<div class = "large-12 columns">
			  		<?php 
					if ($controller->getField ($MEMO, 'img') == '')
						$img_url = $program->getDir().'img/img_bg.jpg';
					else 
						$img_url = 'Data/Users/'.$_SESSION['SO']->getUserInfo ('dir').'/'.$controller->getField ($MEMO, 'img');
					?>
					<label>Pudes añadir una imagen
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
			<br>
			<input type = "hidden" name = "enum" value = "<?php echo $enum; ?>" />
			<div class = "large-12 columns">
				<button class = "button success expand" type="submit">GUARDAR</button>
			</div>
		</form>
	</div>
</div>