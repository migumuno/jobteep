<?php 
$controller = $_SESSION['SO']->getController();
$enum = "experience";
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
?>
<div class = "medium-10 medium-offset-1 columns">
	<div class = "row">
		<ul class="breadcrumbs">
		  <li><a href="?program=panel">Inicio</a></li>
		  <li><a href="?program=panel&menu=experience">Trabajos</a></li>
		  <li class="current"><a href="#">Nuevo Trabajo</a></li>
		</ul>
	</div>
</div>
<div class = "row">
	<div class = "small-10 small-offset-1 columns panel">
		<form data-abide method = "post" action = "?program=panel&menu=<?php echo $enum; ?>&action=<?php echo $action ?>" enctype="multipart/form-data">
			<fieldset>
			<legend>Datos Principales</legend>
		  <div class="row">
		    <div class="medium-6 columns">
		      <label>Empresa <small>requerida</small>
		        <input type = "text" list = "companies" name = "company" placeholder="Nombre de la empresa" value = "<?php echo $controller->getField ($MEMO, 'company') ?>" required autocomplete = "off"/>
		        <datalist id = "companies">
		        	<?php
		        	$result = $controller->getData('company');
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
		    <div class="medium-6 columns">
		      <label>Cargo <small>requerida</small>
		        <input type="text" list = "positions" name = "position" placeholder="Nombre del cargo" value = "<?php echo $controller->getField ($MEMO, 'position') ?>" required autocomplete = "off"/>
		        <datalist id = "positions">
		        	<?php 
		        	$controller = $_SESSION['SO']->getController();
		        	$result = $controller->getData('position');
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
		  </div>
		  <div class = "row">
		  	<div id = "exp_sectores" class = "medium-6 columns">
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
		  	<div class = "medium-6 columns">
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
		  <div class = "row">
		  	<div class = "medium-4 columns">
		  		<label>Tipo de trabajo <small>Importante</small>
		  			<select name = "type">
		  				<?php 
		  				$types = array("...", "Prácticas", "Beca", "Contrato Obra y Servicio", "Contrato Temporal", "Contrato Indefinido", "Emprendedor", "Autónomo", "Freelance", "Voluntariado");
		  				for ($i = 0; $i < count($types); $i++) {
							echo '<option value = "'.$i.'" ';
							if ($controller->getField ($MEMO, 'type') == $i) echo ' selected';
							echo '>'.$types[$i].'</option>';
						}
		  				?>
		  			</select>
		  		</label>
		  	</div>
		  	<div class="medium-4 columns">
		      <label>Fecha de inicio
		      	<?php 
				if ($controller->getField ($MEMO, 'start_date') == '0000-00-00')
					$MEMO['start_date'] = '';
				if ($controller->getField ($MEMO, 'end_date') == '0000-00-00')
					$MEMO['end_date'] = '';
		      	?>
		        <input type="text" name = "start_date" id = "dp1" value = "<?php echo $controller->getField ($MEMO, 'start_date') ?>" placeholder="aaaa/mm/dd"  pattern="^(19|20)\d\d[- /.](0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])$"/>
		      </label>
		      <small class="error">Necesitamos una fecha correcta.</small>
		    </div>
		    <div class="medium-4 columns">
		      <label>Fecha de fin
		        <input type="text" name = "end_date" id = "dp2" value = "<?php echo $controller->getField ($MEMO, 'end_date') ?>" placeholder="aaaa/mm/dd"  pattern="^(19|20)\d\d[- /.](0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])$"/>
		      </label>
		      <small class="error">Necesitamos una fecha correcta.</small>
		    </div>
		  </div>
		  <br>
		  <div class="row">
		    <div id = "exp_description" class="medium-12 columns">
		      <label>Descripción
		        <textarea rows = "10" id = "ck_description" name = "description" ><?php echo $controller->getField ($MEMO, 'description') ?></textarea>
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
				<div id = "exp_'.$relations[$r].'" class = "medium-'.$div_size[$r].' small-'.$div_size[$r].' columns">';
				 
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
				echo '<div class = "row">';
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
				echo '</div>';
				if (isset($_GET['id']))
					$url_relation = '?program=panel&menu=new_'.$relations[$r].'&break=true&id='.$_GET['id'];
				else
					$url_relation = '?program=panel&menu=new_'.$relations[$r].'&break=true';
					
				echo '
		        	<div class = "row">
			  			<div class = "text-left"><button class = "button" type="submit" formaction="'.$url_relation.'">Añadir</button></div>
					</div>
		        </div>
		        ';
				echo '</fieldset><br></div>';
			}
		  	?>
		  </div>
		  <br>
		  <div class = "hidden-field"><input type = "hidden" name = "enum" value = "<?php echo $enum; ?>" /></div>
		  <div class = "row">
			  <div class = "medium-12 columns">
				  <button class = "button expand" type="submit">GUARDAR</button>
			  </div>
		  </div>
		</form>
	</div>
</div>
