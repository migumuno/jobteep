<?php
$enum = "settings";
$controller = $_SESSION['SO']->getController();
$controller->setEnum($enum);
$_SESSION['imagePicker'] = $_SESSION['SO']->getUserInfo ('dir');
$_SESSION['nameImg'] = 'background';
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
			<div class = "row">
				<div class = "large-12 columns">
					<h3>Elige una plantilla</h3>
				</div>
			</div>
			<div class = "row">
				<div class = "large-6 columns">
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
				<div class = "large-3 columns end">
					<a href = "?program=panel&menu=template&template=<?php echo $settings->get('template') ?>" class = "button">CONFIGURAR</a>
				</div>
			</div>
			<div class = "row">
				<div class = "large-12 columns">
					<h3>Privacidad</h3>
				</div>
			</div>
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
			<div class = "row">
				<div class = "large-12 columns">
					<h3>Gráficos visibles</h3>
				</div>
			</div>
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
				  <button class = "button success expand" type="submit">GUARDAR</button>
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