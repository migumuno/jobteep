<?php 
$controller = $_SESSION['SO']->getController();
$enum = "proyect";
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
		  <li><a href="?program=panel&menu=proyect">Proyectos</a></li>
		  <li class="current"><a href="#">Nuevo Proyecto</a></li>
		</ul>
	</div>
</div>
<div class = "row">
	<div class = "small-10 small-offset-1 columns panel">
		<form data-abide method = "post" action = "?program=panel&menu=proyect&action=<?php echo $action ?>">
			<fieldset>
			<legend>Datos Principales</legend>
		  <div class="row">
		  	<div id = "proy_own" class = "medium-4 columns">
		  		<label>¿Es un proyecto propio? <small>Importante</small>
		  			<select id = "self" name = "self" onfocus = "relacionados()" onchange = "relacionados()" autofocus>
		  				<?php 
		  				$bool = array("No", "Si");
		  				for ($i = 0; $i < count($bool); $i++) {
							echo '<option value = "'.$i.'" ';
							if ($controller->getField ($MEMO, 'self') == $i) echo ' selected';
							echo '>'.$bool[$i].'</option>';
						}
		  				?>
		  			</select>
		  		</label>
		  	</div>
		    <div class="medium-8 columns">
		      <label>Título del proyecto <small>requerida</small>
		        <input type = "text" name = "title" value = "<?php echo $controller->getField ($MEMO, 'title') ?>" required autocomplete = "off"/>
		      </label>
		      <small class="error">Este campo es necesario.</small>
		    </div>
		  </div>
		  <div id = "relacionados">
			  <div class = "row">
			    <div id = "proy_trab" class="medium-6 columns">
			      <label>¿Relacionado con algún trabajo?
				      <select name = "experience">
				      	<option value = "0" <?php if($controller->getField ($MEMO, 'experience') == 0) echo 'selected'; ?>>No</option>
				      	<?php 
				      	$controller->setEnum('experience');
				      	$collection = $controller->selectAllElements();
				      	$experience = $collection->getArray();
				      	foreach ($experience as $k => $v) {
							echo '<option value = "'.$v->getId().'"'; if ($v->getId() == $controller->getField ($MEMO, 'experience')) echo ' selected'; echo '>'.$v->get('position').' en '.$v->get('company').'</option>';
						}
				      	?>
				      </select>
			      </label>
			    </div>
			    <div id = "proy_edu" class="medium-6 columns">
			      <label>¿Relacionado con alguna formación?
				      <select name = "education">
				      	<option value = "0" <?php if($controller->getField ($MEMO, 'education') == 0) echo 'selected'; ?>>No</option>
				      	<?php 
				      	$controller->setEnum('education');
				      	$collection = $controller->selectAllElements();
				      	$experience = $collection->getArray();
				      	foreach ($experience as $k => $v) {
							echo '<option value = "'.$v->getId().'"'; if ($v->getId() == $controller->getField ($MEMO, 'education')) echo ' selected'; echo '>'.$v->get('titulation').'</option>';
						}
				      	?>
				      </select>
			      </label>
			    </div>
			  </div>
		  </div>
		  <div id = "reason">
		  	<div class = "row">
		  		<div class="medium-6 columns">
			      <label>¿Motivo del proyecto?
				      <select name = "reason">
				      	<option value = "0" <?php if($controller->getField ($MEMO, 'reason') == 0) echo 'selected'; ?>>...</option>
				      	<option value = "1" <?php if($controller->getField ($MEMO, 'reason') == 1) echo 'selected'; ?>>Emprendimiento</option>
				      	<option value = "2" <?php if($controller->getField ($MEMO, 'reason') == 2) echo 'selected'; ?>>Voluntariado</option>
				      </select>
			      </label>
			    </div>
		  	</div>
		  </div>
		  <div class = "row">
		  	<div id = "proy_sectores" class = "medium-6 columns">
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
		  <div class="row">
		    <div class="medium-6 columns">
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
		    <div class="medium-6 columns">
		      <label>Fecha de fin
		        <input type="text" name = "end_date" id = "dp2" value = "<?php echo $controller->getField ($MEMO, 'end_date') ?>" placeholder="aaaa/mm/dd" />
		      </label>
		    </div>
		  </div>
		  <!-- <div class = "row">
		  	<div class = "medium-6 columns">
		  		<label>¿Te has enfrentado a algo que no habías hecho antes? <small>Importante</small>
		  			<select name = "responsability" id = "responsability" onfocus = "explicate()" onchange = "explicate()">
		  				<?php 
		  				/*$responsabilities = array("No, sin problemas", "Nuevas responsabilidades", "Nuevos conocimientos");
		  				for ($i = 0; $i < count($responsabilities); $i++){
							echo '<option value = "'.$i.'"'; if ($controller->getField ($MEMO, 'responsability') == $i) echo ' selected'; echo '>'.$responsabilities[$i].'</option>';
						}*/
		  				?>
		  			</select>
		  		</label>
		  	</div>
		  </div>
		  <div id = "responsabilities">
			  <div class="row">
			    <div class="medium-12 columns">
			      <label>¿Qué responsabilidades?
			        <textarea rows = "6" id = "ck_description2" name = "responsabilities" placeholder=""><?php /*echo $controller->getField ($MEMO, 'responsabilities')*/ ?></textarea>
			      </label>
			    </div>
			  </div>
			  <br>
		  </div>
		  <div id = "knowledge">
			  <div class="row">
			    <div class="medium-12 columns">
			      <label>¿Qué conocimientos?
			        <textarea rows = "6" id = "ck_description3" name = "knowledge" placeholder=""><?php /*echo $controller->getField ($MEMO, 'knowledge')*/ ?></textarea>
			      </label>
			    </div>
			  </div>
			  <br>
		  </div>
		  <script type="text/javascript">
			<?php 
			/*if ($controller->getField ($MEMO, 'responsability') == 1)
				echo '
				document.getElementById("responsabilities").style.display = "block";
				document.getElementById("knowledge").style.display = "none";
				';
			else if ($controller->getField ($MEMO, 'responsability') == 2)
				echo '
				document.getElementById("responsabilities").style.display = "none";
				document.getElementById("knowledge").style.display = "block";
				';
			else
				echo '
				document.getElementById("responsabilities").style.display = "none";
				document.getElementById("knowledge").style.display = "none";
				';*/
			?>
			
		  </script> -->
		  <div class="row">
		    <div id = "proy_description" class="medium-12 columns">
		    	<label>Descripción <small>Importante</small>
		    	<textarea rows = "10" id = "ck_description" name = "description"><?php echo $controller->getField ($MEMO, 'description') ?></textarea>
		    	</label>
		    </div>
		  </div>
		  </fieldset><br>
		  <div class = "row" >
		  	<?php
			/*$relations = array("skill");
			$names = array("Habilidades");
			$titles = array("name");
			$div_size = array("12");*/
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
				<div id = "proy_'.$relations[$r].'" class = "medium-'.$div_size[$r].' medium-'.$div_size[$r].' small-'.$div_size[$r].' columns">';
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
		  <div class = "medium-12 columns">
			  <button class = "button expand" type="submit">GUARDAR</button>
		  </div>
		</form>
	</div>
</div>
