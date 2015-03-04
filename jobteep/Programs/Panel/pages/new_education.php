<?php 
$controller = $_SESSION['SO']->getController();
$enum = "education";
if(isset($_GET['id'])) {
	$controller->setEnum($enum);
	$obj = $controller->selectSingleElement ();
	$MEMO = $obj->getValuesHtml();
	$action = 'updateElement&id='.$_GET['id'];
} else {
	$action = 'insertElement';
	if (!isset($MEMO))
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
		  <li><a href="?program=panel&menu=education">Formación</a></li>
		  <li class="current"><a href="#">Nueva Formación</a></li>
		</ul>
	</div>
</div>
<div class = "row">
	<div class = "small-10 small-offset-1 columns panel">
		<form data-abide method = "post" action = "?program=panel&menu=<?php echo $enum; ?>&action=<?php echo $action ?>" enctype="multipart/form-data">
			<fieldset>
			<legend>Datos Principales</legend>
			<div class = "row">
				<div class = "medium-4 columns">
					<label>Tipo de Formación <small>Importante</small>
						<select name = "qualification">
			  				<?php 
			  				$qualifications = array("...", "Educación Secundaria", "Curso", "FP Media", "Máster", "Doctorado", "FP Superior", "Carrera");
			  				for ($i = 0; $i < count($qualifications); $i++) {
								echo '<option value = "'.$i.'" ';
								if ($controller->getField ($MEMO, 'qualification') == $i) echo ' selected';
								echo '>'.$qualifications[$i].'</option>';
							}
			  				?>
			  			</select>
					</label>
				</div>
				<div class = "medium-8 columns">
					<label>Titulación <small>requerida</small>
						<input type = "text" list = "titulations" name = "titulation" placeholder="Nombre de tu titulación" value = "<?php echo $controller->getField ($MEMO, 'titulation') ?>" required autocomplete = "off"/>
					</label>
					<datalist id = "titulations">
			        	<?php 
			        	$controller = $_SESSION['SO']->getController();
			        	$result = $controller->getData('titulation');
			        	for($i = 0; $i < $result->num_rows; $i++) {
							$result->data_seek($i);
							$row = $result->fetch_assoc();
							echo '<option value = "'.$row['name'].'">';
						}
			        	?>
			        </datalist>
		      		<small class="error">Necesitamos saber el nombre de tu formación.</small>
				</div>
			</div>
		  <div class="row">
		    <!-- <div class="medium-4 columns">
		      <label>Tipo de Centro <small>Importante</small>
		        <select name = "typeCenter">
	  				<?php 
	  				/*$types = array("...", "Colegio", "Instituto", "Universidad", "Escuela");
	  				for ($i = 0; $i < count($types); $i++) {
						echo '<option value = "'.$i.'" ';
						if ($controller->getField ($MEMO, 'typeCenter') == $i) echo ' selected';
						echo '>'.$types[$i].'</option>';
					}*/
	  				?>
	  			</select>
		      </label>
		    </div> -->
		    <div class="medium-6 columns">
		      <label>Centro de Estudios <small>requerida</small>
		        <input type="text" list = "centers" name = "nameCenter" placeholder="Dónde impartiste la formación" value = "<?php echo $controller->getField ($MEMO, 'nameCenter') ?>" required autocomplete = "off"/>
		        <datalist id = "centers">
		        	<?php 
		        	$controller = $_SESSION['SO']->getController();
		        	$result = $controller->getData('center');
		        	for($i = 0; $i < $result->num_rows; $i++) {
						$result->data_seek($i);
						$row = $result->fetch_assoc();
						echo '<option value = "'.$row['name'].'">';
					}
		        	?>
		        </datalist>
		      </label>
		      <small class="error">Necesitamos saber donde estudiaste.</small>
		    </div>
		    <div class="medium-3 columns">
		      <label>Fecha de inicio
		      	<?php 
				if ($controller->getField ($MEMO, 'start_date') == '0000-00-00')
					$MEMO['start_date'] = '';
				if ($controller->getField ($MEMO, 'end_date') == '0000-00-00')
					$MEMO['end_date'] = '';
		      	?>
		        <input type="text" name = "start_date" id = "dp1" value = "<?php echo $controller->getField ($MEMO, 'start_date') ?>" placeholder="aaaa/mm/dd" />
		      </label>
		    </div>
		    <div class="medium-3 columns">
		      <label>Fecha de fin
		        <input type="text" name = "end_date" id = "dp2" value = "<?php echo $controller->getField ($MEMO, 'end_date') ?>" placeholder="aaaa/mm/dd" />
		      </label>
		    </div>
		  </div>
		  <!-- <div class = "row">
		  	<div class = "medium-6 columns">
		  		<label>Rama de Estudios <small>Importante</small>
		  			<select name = "branch">
		  				<?php 
			        	/*$result = $controller->getData('educationsector');
			        	for($i = 0; $i < $result->num_rows; $i++) {
							$result->data_seek($i);
							$row = $result->fetch_assoc();
							echo '<option value = "'.$row['id_educationsector'].'"'; if ($controller->getField ($MEMO, 'branch') == $row['id_educationsector']) echo ' selected'; echo '>'.$row['name'].'</option>';
						}*/
			        	?>
		  			</select>
		  		</label>
		  	</div>
		  	<div class = "medium-6 columns">
		  		<label>Especialidad <small>Importante</small>
		  			<input type="text" list = "specialties" name = "specialty" placeholder="" value = "<?php /*echo $controller->getField ($MEMO, 'specialty')*/ ?>" autocomplete = "off"/>
		  			<datalist id = "specialties">
		        	<?php
		        	/*$result = $controller->getData('specialty');
		        	for($i = 0; $i < $result->num_rows; $i++) {
						$result->data_seek($i);
						$row = $result->fetch_assoc();
						echo '<option value = "'.$row['name'].'">';
					}*/
		        	?>
		        </datalist>
		  		</label>
		  	</div>
		  </div> -->
		  <div class = "row">
		  	<div class = "medium-4 columns">
				<label>Has terminado? <small>Importante</small>
					<select name = "end">
		  				<?php 
		  				$terminado = array("NO", "SI");
		  				for ($i = 0; $i < count($terminado); $i++) {
							echo '<option value = "'.$i.'" ';
							if ($controller->getField ($MEMO, 'end') == $i) echo ' selected';
							echo '>'.$terminado[$i].'</option>';
						}
		  				?>
		  			</select>
				</label>
			</div>
		  	<div id = "edu_sectores" class = "medium-4 columns">
		  		<label>Sector primario <small>Importante</small>
		  			<select name = "sector">
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
		  	<div class = "medium-4 columns">
		  		<label>Sector secundario <small>Importante</small>
		  			<select name = "subsector">
		  				<option value = "none">...</option>
		  				<?php 
			        	$controller = $_SESSION['SO']->getController();
			        	$result = $controller->getData('sector');
			        	for($i = 0; $i < $result->num_rows; $i++) {
							$result->data_seek($i);
							$row = $result->fetch_assoc();
							echo '<option value = "'.$row['id_sector'].'"'; if ($controller->getField ($MEMO, 'subsector') == $row['id_sector']) echo ' selected'; echo '>'.$row['name'].'</option>';
						}
			        	?>
		  			</select>
		  		</label>
		  	</div>
		  </div>
		  <div class="row">
		    <div id = "edu_description" class="medium-12 columns">
		      <label>Descripción
		        <textarea rows = "10" id = "ck_description" name = "description"><?php echo $controller->getField ($MEMO, 'description') ?></textarea>
		      </label>
		    </div>
		  </div>
		  </fieldset><br>
		  <fieldset>
		  <legend>Puedes Añadir un Certificado</legend>
		  <div class = "row">
		  	<div id = "edu_certificate" class = "medium-12 columns">
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
		   <div class = "row" >
		  	<?php
			$relations = array("language", "travel", "skill");
			$names = array("Idiomas", "Viajes", "Habilidades");
			$expl = array("Relacionados", "Relacionados", "Relacionadas");
			$titles = array("name", "title", "name");
			$div_size = array("12", "12", "12");
			for ($r = 0; $r < count($relations); $r++) {
				
				echo '<div class = "small-12 columns">
				<fieldset>
				<legend>'.$names[$r].' '.$expl[$r].'</legend>';
				echo '
				<div id = "edu_'.$relations[$r].'" class = "medium-'.$div_size[$r].' small-'.$div_size[$r].' columns">';
				$controller = $_SESSION['SO']->getController();
				 
				$controller->setEnum($relations[$r]);
				$collection = $controller->selectAllElements();
				$relation = $collection->getArray();
				 
				if (isset($_GET['id'])) {
					$controller->setEnum($enum.$relations[$r]);
					$collection2 = $controller->selectAllElements();
					$relation_bbdd = $collection2->getArray();
				
					$relation_arr = array();
					foreach ($relation_bbdd as $k => $v) {
						if ($v->get('id_'.$enum) == $_GET['id'])
							$relation_arr[] = $v->get('id_'.$relations[$r]);
					}
				}
				echo '<div class = "row"><div class = "small-12 columns">';
				$i = 0;
				foreach ($relation as $k => $v) {
					$i++;
					echo '
						<div class = "medium-3 small-6 columns">
							<div class = "medium-12 columns">
					  			<div class = "row">
					  				<label>'.$v->get($titles[$r]).'</label>
					  			</div>
						  		<div class = "row">
							  		<div class="switch">
									  <input id="'.$relations[$r].$i.'" name = "'.$relations[$r].'[]" value = "'.$v->get($titles[$r]).'" type="checkbox"'; if (isset ($_GET['id']) && in_array($v->getId(), $relation_arr)) echo 'checked'; echo '>
									  <label for = "'.$relations[$r].$i.'"></label>
									</div>
								</div>
		        			</div>
						</div>
			    		';
				}
				echo '</div></div>';
				if (isset($_GET['id']))
					$url_relation = '?program=panel&menu=new_'.$relations[$r].'&break=true&id='.$_GET['id'];
				else
					$url_relation = '?program=panel&menu=new_'.$relations[$r].'&break=true';
					
				echo '
		        	<div class = "row"><div class = "small-12 columns">
			  			<div class = "text-left"><button class = "button" type="submit" formaction="'.$url_relation.'">Añadir</button></div>
					</div></div>
		        </div>
		        ';
				echo '</fieldset><br></div>';
			}
		  	?>
		  </div>
		  <br>
		  <div class = "hidden-field"><input type = "hidden" name = "enum" value = "<?php echo $enum; ?>" /></div>
		  <div class = "medium-12 columns">
			  <button class = "button expand" type="submit">GUARDAR</button>
		  </div>
		</form>
	</div>
</div>
