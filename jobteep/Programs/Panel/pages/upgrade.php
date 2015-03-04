<?php
$enum = "upgrade";
$controller = $_SESSION['SO']->getController();
$controller->setEnum($enum);
$collection = $controller->selectAllElements();
$upgrade_array = $collection->getArray();
foreach ($upgrade_array as $k => $v) {
	$upgrade = $v;
}
?>
<div class = "medium-10 medium-offset-1 columns">
	<div class = "row">
		<ul class="breadcrumbs">
		  <li><a href="?program=panel">Inicio</a></li>
		  <li class="current"><a href="#">Deseos</a></li>
		</ul>
	</div>
</div>
<div class = "row">
	<div class = "small-10 small-offset-1 columns panel">
		<form data-abide method = "post" action = "?program=panel&menu=upgrade&action=updateElement&id=<?php echo $upgrade->getId(); ?>">
			<fieldset>
			<legend>¿Dónde desearías trabajar?</legend>
			<div class = "row">
				<?php 
				$companies = array("Primera empresa", "Segunda empresa", "Tercera empresa", "Cuarta empresa", "Quinta empresa");
				$placeholders = array("Google Inc.", "Indra Sistemas", "Técnicas Reunidas", "Nestle", "P&G Procter & Gamble");
				for ($i = 0; $i < count($companies); $i++) {
					$j = $i + 1;
					echo '
					<div class = "medium-4 columns">
						<label>'.$companies[$i].'
				        <input type = "text" list = "empresas" name = "company'.$j.'" value = "'.$upgrade->get('company'.$j).'" autocomplete = "off"/>
				      	<datalist id = "empresas">';
				        	$result = $controller->getData('company');
				        	for($h = 0; $h < $result->num_rows; $h++) {
								$result->data_seek($h);
								$row = $result->fetch_assoc();
								echo '<option value = "'.$row['name'].'"></option>';
							}
				        echo '</datalist>
				      </label>
					</div>
					';
				    unset($result);
				    unset($row);
				}
				?>
			</div>
			</fieldset><br>
			<fieldset>
			<legend>¿Cuáles son tus objetivos?</legend>
			<div class = "row">
				<div class = "medium-12 columns">
					<label>Primer Objetivo
						<input type = "text" name = "obj1" value = "<?php echo $upgrade->get('obj1') ?>">
					</label>
				</div>
				<div class = "medium-12 columns">
					<label>Segundo Objetivo
						<input type = "text" name = "obj2" value = "<?php echo $upgrade->get('obj2') ?>">
					</label>
				</div>
				<div class = "medium-12 columns">
					<label>Tercer Objetivo
						<input type = "text" name = "obj3" value = "<?php echo $upgrade->get('obj3') ?>">
					</label>
				</div>
			</div>
			</fieldset><br>
			<fieldset>
			<legend>¿Qué quieres conseguir?</legend>
			<div class = "row">
				<div class = "medium-12 columns">
					<label>Mi foco está en...
						<input type = "text" name = "focus" value = "<?php echo $upgrade->get('focus') ?>">
					</label>
				</div>
			</div>
			</fieldset><br>
			<fieldset>
			<legend>Un broche final</legend>
			<div class = "row">
				<div class = "medium-12 columns">
					<label>Una frase con la que acabar tu curriculum
						<input type = "text" name = "end" value = "<?php echo $upgrade->get('end') ?>">
					</label>
				</div>
			</div>
			</fieldset><br>
			<!-- <div class="row">
		   		<div class="medium-12 columns">
			      <label>
			        <textarea rows = "10" id = "ck_description" name = "future"><?php /*echo $upgrade->get('future')*/ ?></textarea>
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