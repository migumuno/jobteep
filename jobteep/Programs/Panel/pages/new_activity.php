<?php 
$controller = $_SESSION['SO']->getController();
$enum = "activity";
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
		  <li><a href="?program=panel&menu=activity">Actividades</a></li>
		  <li class="current"><a href="#">Nueva Actividad</a></li>
		</ul>
	</div>
</div>
<div class = "row">
	<div class = "small-10 small-offset-1 columns panel">
		<form data-abide method = "post" action = "?program=panel&menu=activity&action=<?php echo $action ?>">
		<fieldset>
			<legend>Datos Principales</legend>
		  <div class="row">
		  	<div class = "medium-4 columns">
		  		<label>Tipo de actividad
		  			<select name = "category">
		  				<?php 
		  				$categories = array("Evento", "Voluntariado", "Hablar en público", "Innovación/Emprendimiento", "Otro");
		  				for ($i = 0; $i < count($categories); $i++){
							echo '<option value = "'.$i.'"'; if ($controller->getField ($MEMO, 'category') == $i) echo ' selected'; echo '>'.$categories[$i].'</option>';
						}
		  				?>
		  			</select>
		  		</label>
		  	</div>
		    <div class="medium-8 columns">
		      <label>Título de la actividad <small>requerida</small>
		        <input type = "text" name = "title" placeholder="Pon un título identificativo" value = "<?php echo $controller->getField ($MEMO, 'title'); ?>" required autocomplete = "off"/>
		      </label>
		      <small class="error">Este campo es necesario.</small>
		    </div>
		  </div>
		  <div class = "row">
		  	<div class = "medium-6 columns">
		  		<label>Sector <small>Importante</small>
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
		  	<div class="medium-4 columns">
		      <label>Fecha de la actividad
		      	<?php 
				if ($controller->getField ($MEMO, 'start_date') == '0000-00-00')
					$MEMO['start_date'] = '';
		      	?>
		        <input type="text" name = "start_date" id = "dp1" value = "<?php echo $controller->getField ($MEMO, 'start_date') ?>" placeholder="aaaa/mm/dd" />
		      </label>
		    </div>
		  </div>
		  	<!-- <div class = "medium-6 columns">
		  		<label>¿Te has enfrentado a algo que no habías hecho antes? <small>Importante</small>
		  			<select name = "responsability" id = "responsability" onfocus = "explicate()" onchange = "explicate()" autofocus>
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
		  </div> -->
		  <div class="row">
		    <div class="medium-12 columns">
		      <label>Descripción
		        <textarea rows = "10" id = "ck_description" name = "description" placeholder=""><?php echo $controller->getField ($MEMO, 'description') ?></textarea>
		      </label>
		    </div>
		  </div>
		  <br>
		  <!-- <div class = "row" >
		  	<?php
			/*$relations = array("language", "travel", "skill");
			$names = array("Idiomas", "Viajes", "Habilidades");
			$titles = array("name", "title", "name");
			$div_size = array("12", "12", "12");
			for ($r = 0; $r < count($relations); $r++) {
				echo '
				<div class = "medium-'.$div_size[$r].' medium-'.$div_size[$r].' small-'.$div_size[$r].' columns">
			  		<h3>'.$names[$r].'</h3>
				';
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
		  				<div class = "medium-3 columns">
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
			}*/
		  	?>
		  </div> -->
		  
		</fieldset><br>
		  <input type = "hidden" name = "enum" value = "<?php echo $enum; ?>" />
		  <div class = "medium-12 columns">
			  <button class = "button expand" type="submit">GUARDAR</button>
		  </div>
		</form>
	</div>
</div>
