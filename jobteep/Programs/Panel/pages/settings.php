<?php
$enum = "settings";
$controller = $_SESSION['SO']->getController();
$controller->setEnum($enum);
$_SESSION['imagePicker'] = $_SESSION['SO']->getUserInfo ('dir');
$_SESSION['nameImg'] = 'teepcardImg';
?>
<div class = "large-10 large-offset-1 columns">
	<div class = "row">
		<ul class="breadcrumbs">
		  <li><a href="?program=panel">Inicio</a></li>
		  <li class="current"><a href="#">Configuración</a></li>
		</ul>
	</div>
</div>
<div class = "row">
	<div class = "small-10 small-offset-1 columns panel">
		<form data-abide method = "post" action = "?program=panel&menu=settings&action=updateElement&id=<?php echo $settings->getId(); ?>">
			<fieldset>
			<legend>Configura tu Teep</legend>
			<div class = "row">
				<div class = "small-12 columns">
					<label>
		  			<select name = "template">
		  				<?php 
			        	$where = "state = 1";
			        	$result = $controller->getTemplates('templates', $where);
			        	for($i = 0; $i < $result->num_rows; $i++) {
							$result->data_seek($i);
							$row = $result->fetch_assoc();
							echo '<option value = "'.$row['name'].'"'; if ($settings->get('template') == $row['name']) echo ' selected'; echo '>'.$row['name'].'</option>';
						}
			        	?>
		  			</select>
		  			</label>
				</div>
				<div class = "small-12 columns end">
					<a href = "?program=panel&menu=template&template=<?php echo $settings->get('template') ?>" class = "button">CONFIGURAR</a>
				</div>
			</div>
			</fieldset><br>
			<?php if ($_SESSION['SO']->getUID() == 1) { ?>
			<fieldset>
				<legend>Configura tu Teepcard</legend>
				<div class = "row">
					<div class = "medium-12 columns">
				  		<?php 
						if ($settings->get('teepcardImg') == '' || is_null($settings->get('teepcardImg')))
							$img_url = $program->getDir().'img/img_bg.png';
						else 
							$img_url = 'Data/Users/'.$_SESSION['SO']->getUserInfo ('dir').'/'.$settings->get('teepcardImg');
						?>
						<div class = "medium-3 columns">
							<label>Fondo Teepcard (Recomendado: 2700x3500, JPG)
								<img id = "header_img" src = "<?php echo $img_url; ?>" width = "100%">
								<div class = "row">
									<div class = "small-12 columns">
									<br>
									<div class = "medium-6 columns"><a href="#" data-ip-modal="#headerModal" class="button expand">Subir</a></div>
									<div class = "medium-6 columns"><a onclick = "document.getElementById('perfil').value = ''; document.getElementById('header_img').src = '<?php echo $program->getDir().'img/img_bg.png' ?>';" class = "button alert expand">Quitar</a></div>
									<input type = "hidden" name = "teepcardImg" value = "<?php echo $settings->get('teepcardImg'); ?>" id = "perfil">
									</div>
								</div>
							</label>
						</div>
						<div class = "medium-9 columns">
							<div class = "medium-6 columns">
								<label>Color Texto
									<select name = "teepcardTxtColor">
										<option value = "">Por defecto</option>
										<option value = "blanco" <?php if ($settings->get('teepcardTxtColor') == 'blanco') echo 'selected'; ?>>Blanco</option>
										<option value = "negro" <?php if ($settings->get('teepcardTxtColor') == 'negro') echo 'selected'; ?>>Negro</option>
										<option value = "gris" <?php if ($settings->get('teepcardTxtColor') == 'gris') echo 'selected'; ?>>Gris</option>
									</select>
								</label>
							</div>
							<div class = "medium-6 columns">
								<label>Fuente
									<select name = "teepcardFont">
										<option class = "Sawasdee" value = "">Por defecto</option>
										<option class = "AlexBrush" value = "AlexBrush.ttf" <?php if ($settings->get('teepcardFont') == 'AlexBrush.ttf') echo 'selected'; ?>>AlexBrush</option>
										<option class = "ExoRegular" value = "ExoRegular.otf" <?php if ($settings->get('teepcardFont') == 'ExoRegular.otf') echo 'selected'; ?>>ExoRegular</option>
										<option class = "KaushanScript" value = "KaushanScript.otf" <?php if ($settings->get('teepcardFont') == 'KaushanScript.otf') echo 'selected'; ?>>KaushanScript</option>
										<option class = "Purisa" value = "Purisa.ttf" <?php if ($settings->get('teepcardFont') == 'Purisa.ttf') echo 'selected'; ?>>Purisa</option>
										<option class = "QuicksandDash" value = "QuicksandDash.otf" <?php if ($settings->get('teepcardFont') == 'QuicksandDash.otf') echo 'selected'; ?>>QuicksandDash</option>
									</select>
								</label>
							</div>
							<div class = "medium-6 columns">
								<label>Tamaño Fuente
									<input type = "number" name = "teepcardFontSize" value = "<?php echo $settings->get('teepcardFontSize') ?>">
								</label>
						</div>
				  	</div>
				</div>
			</fieldset><br>
			<?php } ?>
			<fieldset>
			<legend>Privacidad</legend>
			<div class = "row">
				<div class = "large-4 columns">
					<label>Visibilidad de tu curriculum <small>Requerido</small>
						<select name = "public">
			  				<?php 
			  				$visibility = array("Privado", "Público");
							for ($i = 0; $i < count($visibility); $i++) {
								echo '<option value = "'.$i.'" ';
								if ($settings->get('public') == $i) echo ' selected';
								echo '>'.$visibility[$i].'</option>';
							}
			  				?>
			  			</select>
					</label>
				</div>
			</div>
			</fieldset><br>
			<fieldset>
			<legend>Gráficos visibles</legend>
			<div class = "row">
				<?php 
				$names = array("Idiomas", "Aptitudes", "Actividades", "Cultura", "Aficiones", "Deporte", "Globalización", "Próximos Objetivos");
				$secciones = array("language", "skill", "activity", "mtlculture", "mtlart", "mtlsport", "travel", "objetives");
				for ($i = 0; $i < count($secciones); $i++) {
					if ($settings->get($secciones[$i])) $value = 1;
					else $value = 0;
					echo '
					<div class = "medium-3 columns">
						<div class = "medium-12 columns">
				  			<div class = "row">
				  				<label>'.$names[$i].'</label>
				  			</div>
					  		<div class = "row">
						  		<div class="switch">
								  <input id="'.$secciones[$i].'" name = "'.$secciones[$i].'" type="checkbox"'; if ($value == 1) echo 'checked'; echo '>
								  <label for = "'.$secciones[$i].'"></label>
								</div>
							</div>
						</div>
		        	</div>
					';
				}
				?>
			</div>
			</fieldset>
			<br>
			<fieldset>
			<legend>Analytics</legend>
			<div class = "row">
				<div class = "small-12 columns">
					<label>Añade el script de analytics para poder controlar tu teep.
			    	<textarea rows = "6" name = "analytics"><?php echo $settings->get('analytics') ?></textarea>
			    	</label>
				</div>
			</div>
			</fieldset><br>
			<!-- <div class = "row">
				<div class = "large-12 columns">
					<h3>Personalización</h3>
				</div>
			</div>
			<div class = "row">
				<div class = "large-3 columns">
					<label>Imagen de fondo <small>El explorador puede tardar en actualizar la imagen</small>
						<span id = "img_bg">
						<?php 
						/*if (isset($background) && $background != '') {
							echo '<img id = "header_img" src = "Data/Users/'.$_SESSION['SO']->getUserInfo ('dir').'/'.$background.'">';
						} else
							echo '<img id = "header_img" src = "'.$program->getDir().'img/bg.jpg">';*/
						?>
						</span>
						<a href="#" data-ip-modal="#headerModal" class="button expand">Subir</a>
						<a href = "#" onclick = "document.getElementById('perfil').value = ''; document.getElementById('img_bg').innerHTML = '';" class = "button alert expand">Quitar</a>
						<input type = "hidden" name = "background" value = "<?php /*echo $settings->get('background');*/ ?>" id = "perfil">
					</label>
				</div>
			</div>
			<br> -->
			<input type = "hidden" name = "enum" value = "<?php echo $enum; ?>" />
			<div class = "large-12 columns">
				  <button class = "button expand" type="submit">GUARDAR</button>
			</div>
		</form>
		<!-- <div class = "row">
			<div class = "large-12 columns">
				<h3>Versiones</h3>
			</div>
		</div>
		<div class = "row">
			<div class = "large-4 columns">
				<div class = "large-12 columns panel callout radius text-center">
					<dl>
						<dt>VERSIÓN</dt>
						<dd><span class="label secondary">INICIAL</span></dd>
						<dd>
						<?php 
						/*if ($controller->getVersion () != 0)
							echo '
							<form data-abide method = "post" action = "?program=panel&menu=settings&action=version">
								<input type = "hidden" name = "v" value = "0">
								<input class = "button" type = "submit" value = "SELECCIONAR">
							</form>
							';
						else 
							echo '<span class = "button success">SELECCIONADA</span>';*/
						?>
						</dd>
					</dl>
				</div>
			</div>
			<?php
			/*if ($settings->get('v1') == 0) {
				echo '
				<div class = "large-4 columns">
					<div class = "large-12 columns end panel callout radius text-center">
						<dl>
							<dt>VERSIÓN</dt>
							<dd><span class="label secondary">SECUNDARIA</span></dd>
							<form data-abide method = "post" action = "?program=panel&menu=settings&action=genVersion">
								<label>Dominio <span id = "domain_error"></span> <span data-tooltip class="has-tip" title="Elige un dominio para la nueva versión><img alt="The Jobfeel" src="Programs/Panel/img/question.png" width = "20px"></span> <small>requerido</small>
									<input type = "text" id = "domain" name = "domain" value = "" pattern="^[a-z0-9_]*$" required>
								</label>
								<small class="error">Necesitamos saber el dominio para que puedan ver tu curriculum. Están permitidas letras minúsculas, números y _</small>
								<input type = "hidden" name = "v" value = "1">
								<input class = "button" type = "submit" value = "GENERAR">
							</form>
						</dl>
					</div>
				</div>
				';
			} else if ($settings->get('v1') == 1) {
				if ($controller->getVersion () != 1)
					echo '
					<div class = "large-4 columns">
						<div class = "large-12 columns end panel callout radius text-center">
							<dl>
								<dt>VERSIÓN</dt>
								<dd><span class="label secondary">SECUNDARIA</span></dd>
								<dd>
									<form data-abide method = "post" action = "?program=panel&menu=settings&action=version">
										<input type = "hidden" name = "v" value = "1">
										<input class = "button" type = "submit" value = "SELECCIONAR">
									</form>
								</dd>
							</dl>
						</div>
					</div>
					';
				else
					echo '
					<div class = "large-4 columns">
						<div class = "large-12 columns end panel callout radius text-center">
							<dl>
								<dt>VERSIÓN</dt>
								<dd><span class="label secondary">SECUNDARIA</span></dd>
								<span class = "button success">SELECCIONADA</span>
							</dl>
						</div>
					</div>
					';
			}*/
			?>
		</div> -->
	</div>
</div>