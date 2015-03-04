<?php
$controller = $_SESSION['SO']->getController();
$enum = 'travel';
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
		  <li><a href="?program=panel&menu=travel">Viajes</a></li>
		  <li class="current"><a href="#">Nuevo Viaje</a></li>
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
		      <label>Tipo de viaje
		        <select name = "type">
		        	<?php 
		        	$travel_types = array("Sin Especificar", "Ocio", "Trabajo", "Estudios");
		        	for ($i = 0; $i < count($travel_types); $i++) {
						echo '<option value="'.$i.'" '; if ($controller->getField ($MEMO, 'type') == $i) echo 'selected'; echo '>'.$travel_types[$i].'</option>';
					}
		        	?>
		        </select>
		      </label>
		    </div>
		    <div class="medium-8 columns">
		    	<label>Título del viaje <small>requerida</small>
		       		<input type = "text" name = "title" value = "<?php echo $controller->getField ($MEMO, 'title') ?>" placeholder="Pon un título identificativo" autofocus required autocomplete = "off"/>
		    	</label>
		    	<small class="error">Este campo es necesario.</small>
		    </div>
		  </div>
		  <div class="row">
		    <div class="medium-4 columns">
		      <label>Fecha de inicio
		        <input type="text" name = "start_date" id = "dp1" value = "<?php echo $controller->getField ($MEMO, 'start_date') ?>" placeholder="aaaa/mm/dd" />
		      </label>
		    </div>
		    <div class="medium-4 columns">
		      <label>Fecha de fin
		        <input type="text" name = "end_date" id = "dp2" value = "<?php echo $controller->getField ($MEMO, 'end_date') ?>" placeholder="aaaa/mm/dd" />
		      </label>
		    </div>
		  </div>
		  <div class = "row">
		  	<div class="medium-12 columns">
		      <label>La historia
		        <textarea rows = "10" id = "ck_description" name = "story"><?php echo html_entity_decode($controller->getField ($MEMO, 'story')) ?></textarea>
		      </label>
		    </div>
		  </div>
		  <br>
		  <div class = "row" >
		  	<div class = "medium-8 columns">
			  	<label>¿Dónde viajaste? <small>requerida</small>
		       		<input type = "text" id = "location" name = "location" value = "<?php echo $controller->getField ($MEMO, 'location') ?>" placeholder="Ciudad, País" autofocus required autocomplete = "off"/>
		    	</label>
		    	<small class="error">Este campo es necesario.</small>
		    </div>
		    <div class = "medium-4 columns">
		    	<a href="#map" class="button google expand" >Comprobar</a>
		    </div>
		  </div>
		  <div id = "test"></div>
		  <div class = "row">
				<div class = "medium-12 columns">
					<a name = "map"></a>
					<div id = "mapa" style="width:100%;"></div>
				</div>
		  </div>
		  </fieldset><br>
		  <fieldset>
		  <legend>Pudes Añadir una Imagen</legend>
		  <div class = "row">
		  	<div class = "medium-12 columns">
		  		<?php 
				if ($controller->getField ($MEMO, 'img') == '')
					$img_url = $program->getDir().'img/img_bg.png';
				else 
					$img_url = 'Data/Users/'.$_SESSION['SO']->getUserInfo ('dir').'/'.$controller->getField ($MEMO, 'img');
				?>
				<label>
					<?php 
					if ($img_url != '')
						echo '<img id = "header_img" src = "'.$img_url.'" width = "100%">';
					?>
					<br><br>
					<div class = "row">
						<div class = "medium-6 small-12 columns"><a href="#" data-ip-modal="#headerModal" class="button expand">Subir</a></div>
						<div class = "medium-6 small-12 columns"><a href = "#" onclick = "document.getElementById('perfil').value = ''; document.getElementById('header_img').src = '<?php echo $program->getDir().'img/img_bg.png' ?>';" class = "button alert expand">Quitar</a></div>
						<input type = "hidden" name = "img" value = "<?php echo $controller->getField ($MEMO, 'img'); ?>" id = "perfil">
					</div>
				</label>
		  	</div>
		  </div>
		  </fieldset><br>
		  <div class = "row" >
		  	<?php
			$relations = array("language");
			$names = array("Idiomas");
			$expl = array("Relacionados");
			$titles = array("name");
			$div_size = array("12");
			for ($r = 0; $r < count($relations); $r++) {
				echo '<div class = "small-12 columns">
				<fieldset>
				<legend>'.$names[$r].' '.$expl[$r].'</legend>';
				echo '
				<div class = "medium-'.$div_size[$r].' small-'.$div_size[$r].' columns">';
				 
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
