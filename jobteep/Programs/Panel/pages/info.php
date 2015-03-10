<?php
$enum = "info";
$controller = $_SESSION['SO']->getController();
$url = $controller->getUrlFbk('panel');
$controller->setEnum($enum);
$collection = $controller->selectAllElements();
$info_array = $collection->getArray();
foreach ($info_array as $k => $v) {
	$info = $v;
}
$_SESSION['imagePicker'] = $_SESSION['SO']->getUserInfo ('dir');
$_SESSION['nameImg'] = 'info';
?>
<div class = "medium-10 medium-offset-1 columns">
	<div class = "row">
		<ul class="breadcrumbs">
		  <li><a href="?program=panel">Inicio</a></li>
		  <li class="current"><a href="#">Datos Personales</a></li>
		</ul>
	</div>
</div>
<div class = "row">
	<form name = "Intro" data-abide method = "post" action = "?program=panel&menu=info&action=updateElement&id=<?php echo $info->getId(); ?>" enctype="multipart/form-data">
	<div class = "small-10 small-offset-1 columns panel">
		<div class = "row">
			<div class = "small-12 columns">
				<fieldset>
				<legend>Elige los sectores con los que te identificas</legend>
				<div id = "info_sectores" class = "medium-12 columns">
					<?php 
					$sector_fields = array("Primer sector", "Segundo sector", "Tercer sector");
					for ($i = 0; $i < count($sector_fields); $i++) {
						$sector = $i + 1;
						echo '
						<div class = "medium-4 columns">
							<label>'.$sector_fields[$i].'
								<select name = "sector'.$sector.'">
					  				<option value = "none">...</option>';
						        	$controller = $_SESSION['SO']->getController();
						        	$result = $controller->getData('sector');
						        	for($j = 0; $j < $result->num_rows; $j++) {
										$result->data_seek($j);
										$row = $result->fetch_assoc();
										echo '<option value = "'.$row['id_sector'].'"'; if ($info->get('sector'.$sector) == $row['id_sector']) echo ' selected'; echo '>'.$row['name'].'</option>';
									}
						echo '
			  					</select>
							</label>
						</div>
						';
					}
					?>
				</div>
				</fieldset><br>
				<fieldset>
				<legend>Tus intereses</legend>
				<div class = "medium-12 columns">
					<div class = "row">
						<div class = "medium-4 columns">
							<label>¿Qué eres? <small>Requerido</small>
								<select name = "iam">
					  				<?php 
					  				$iam = array("Estudiante", "Estudio y trabajo", "Trabajador", "Autónomo", "Emprendedor", "Estoy en paro");
					  				for ($i = 0; $i < count($iam); $i++) {
										echo '<option value = "'.$i.'" ';
										if ($info->get('iam') == $i) echo ' selected';
										echo '>'.$iam[$i].'</option>';
									}
					  				?>
					  			</select>
							</label>
						</div>
						<div class = "medium-4 columns">
							<label>¿Qué estas buscando? <small>Requerido</small>
								<select name = "lookingfor">
					  				<?php 
					  				$lookingfor = array("Nada", "Prácticas", "Beca", "Formación", "Primer empleo", "Trabajo", "Voluntariado", "Inversión", "Apoyo");
					  				for ($i = 0; $i < count($lookingfor); $i++) {
										echo '<option value = "'.$i.'" ';
										if ($info->get('lookingfor') == $i) echo ' selected';
										echo '>'.$lookingfor[$i].'</option>';
									}
					  				?>
					  			</select>
							</label>
						</div>
						<div class = "medium-4 columns">
							<label>Disponibilidad <small>Requerido</small>
								<select name = "disponibility">
					  				<?php 
					  				$disponibility = array("Ninguna", "Parcial mañanas", "Parcial Tardes", "Completa", "Fines de semana", "Dispuesto a todo");
					  				for ($i = 0; $i < count($disponibility); $i++) {
										echo '<option value = "'.$i.'" ';
										if ($info->get('disponibility') == $i) echo ' selected';
										echo '>'.$disponibility[$i].'</option>';
									}
					  				?>
					  			</select>
							</label>
						</div>
					</div>
				</div>
				</fieldset><br>
				<fieldset>
				<legend>Y ahora tus datos</legend>
				<div class = "medium-4 columns">
					<?php 
					if ($info->get('img') == 'facebook')
						$img_url = 'http://graph.facebook.com/'.$info->get('id_fbk').'/picture?width=300&height=300';
					else if ($info->get('img') == '')
						$img_url = 'Data/Users/profile.png';
					else {
						$pos = strpos($info->get('img'), 'https');
						if ($pos !== false)
							$img_url = $info->get('img');
						else
							$img_url = 'Data/Users/'.$_SESSION['SO']->getUserInfo ('dir').'/'.$info->get('img');
					}
					?>
					<div class = "row"><img id = "avatar" src = "<?php echo $img_url; ?>" width = "100%"></div><br>
					<div class = "row">
						<a href="#" data-ip-modal="#avatarModal" class="button expand">SUBIR</a>
						<input type = "hidden" name = "img" value = "<?php echo $info->get('img'); ?>" id = "perfil">
					</div>
				</div>
				<div class = "medium-8 columns">
					<div class = "row">
						<div class = "medium-6 columns">
							<label>Nombre <small>requerido</small>
				        		<input type = "text" name = "name" value = "<?php echo $info->get('name'); ?>" required />
					      	</label>
					     	 <small class="error">Necesitamos saber tu nombre.</small>
						</div>
						<div class = "medium-6 columns">
				     	 	<label>Apellidos <small>requerido</small>
						        <input type = "text" name = "surname" value = "<?php echo $info->get('surname') ?>" required />
						    </label>
						    <small class="error">Necesitamos saber tus apellidos.</small>
						</div>
					</div>
					<div class = "row">
						<div class = "medium-6 columns">
							<label>Fecha nacimiento <small>requerido</small>
						        <input type = "text" name = "birthday" id = "birthday" placeholder="aaaa/mm/dd" value = "<?php echo date('Y/m/d', strtotime($info->get('birthday'))); ?>" required pattern="^(19|20)\d\d[- /.](0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])$" />
							</label>
						   	<small class="error">Necesitamos una fecha correcta, a las empresas les gustará saber tu edad.</small>
						</div>
						<div class = "medium-6 columns">
				     	 	<label>Teléfono <small></small>
						        <input type = "text" name = "telf1" placeholder = "555555555" value = "<?php echo $info->get('telf1'); ?>" />
							</label>
						</div>
					</div>
					<div class = "row">
						<div id = "info_nativo" class = "medium-6 columns">
							<label>Idioma nativo <small>requerido</small>
					        <input type = "text" list = "languages" name = "native_language" placeholder="El nombre de tu idioma nativo" value = "<?php echo $info->get('native_language') ?>" required autocomplete = "off"/>
					        <datalist id = "languages">
					        	<?php 
					        	$result = $controller->getData('language');
					        	for($i = 0; $i < $result->num_rows; $i++) {
									$result->data_seek($i);
									$row = $result->fetch_assoc();
									echo '<option value = "'.$row['name'].'">';
								}
					        	?>
					        </datalist>
					    </label>
					    <small class="error">Necesitamos saber tus idioma.</small>
						</div>
					</div>
					<div class = "row">
						<div class = "medium-6 columns">
							<label>Ciudad <small>requerido</small>
					        	<input type = "text" name = "city" id = "city" value = "<?php echo $info->get('city'); ?>" required />
					      	</label>
					     	<small class="error">A las empresas les gustará saber de donde eres.</small>
						</div>
						<div class = "medium-6 columns">
				     	 	<label>País <small>requerido</small>
					        	<input type = "text" name = "country" id = "country" value = "<?php echo $info->get('country'); ?>" required />
					      	</label>
					      	<small class="error">A las empresas les gustará saber de donde eres.</small>
						</div>
					</div>
					<div class = "row">
						<div class = "medium-6 columns">
							<div class="email-field">
								<label>Email público <span data-tooltip class="has-tip" title="Este email aparecerá en tu perfil de forma pública."><img alt="The Jobfeel" src="Programs/Panel/img/question.png" width = "20px"></span>
							        <input type = "email" name = "email" id = "email" placeholder="email@email.com" value = "<?php echo $info->get('email'); ?>"/>
							    </label>
							    <small class="error">El email introducido no es correcto.</small>
							</div>
						</div>
						<div id = "info_dominio" class = "medium-6 columns">
							<label>Elige tu Dominio <span id = "domain_error"></span> <span data-tooltip class="has-tip" title="El dominio es la dirección de tu perfil: www.jobteep.com/dominio"><img alt="The Jobfeel" src="Programs/Panel/img/question.png" width = "20px"></span> <small>requerido</small>
						        <input type = "text" name = "domain" id = "domain" value = "<?php echo $info->get('domain'); ?>" pattern="^[a-z0-9_]*$" required />
						    </label>
						    <small class="error">Necesitamos saber el dominio para que puedan ver tu curriculum. Están permitidas letras minúsculas, números y _</small>
						</div>
					</div>
					<div class = "row">
						<div class = "medium-12 columns">
							<label>En dos palabras <small>Importante</small>
								<input type = "text" name = "profession" placeholder = "Descríbete en dos o tres palabras" id = "profession" value = "<?php echo $info->get('profession'); ?>" />
							</label>
						</div>
					</div>
					<div class = "row">
						<div class = "medium-12 columns">
							<label>Un Eslogan  <small>Importante</small>
						        <input type = "text" name = "slogan" placeholder="Añade un slogan con el que te sientas identificado." id = "slogan" value = "<?php echo $info->get('slogan'); ?>" />
						    </label>
						</div>
					</div>
				</div>
				<div class = "medium-12 columns">
					<div class = "row">
						<div class = "medium-4 columns">
							<div class="row collapse">
						        <label><img alt="facebook" src="<?php echo $program->getDir(); ?>img/fbk.png" width = "20px"> Facebook</label>
						        <div class="small-3 columns">
						          <span class="postfix">http://</span>
						        </div>
						        <div class="small-9 columns">
						          <input type="text" placeholder="Pon el enlace completo" name = "facebook" value = "<?php echo $info->get('facebook'); ?>"/>
						        </div>
						    </div>
						</div>
						<div class = "medium-4 columns">
							<div class="row collapse">
						        <label><img alt="linkedin" src="<?php echo $program->getDir(); ?>img/lnkdn.png" width = "20px"> Linkedin</label>
						        <div class="small-3 columns">
						          <span class="postfix">http://</span>
						        </div>
						        <div class="small-9 columns">
						          <input type="text" placeholder="Pon el enlace completo" name = "linkedin" value = "<?php echo $info->get('linkedin'); ?>"/>
						        </div>
						    </div>
						</div>
						<div class = "medium-4 columns">
							<div class="row collapse">
						        <label><img alt="twitter" src="<?php echo $program->getDir(); ?>img/twitter.png" width = "20px"> Twitter</label>
						        <div class="small-3 columns">
						          <span class="postfix">http://</span>
						        </div>
						        <div class="small-9 columns">
						          <input type="text" placeholder="Pon el enlace completo" name = "twitter" value = "<?php echo $info->get('twitter'); ?>"/>
						        </div>
						    </div>
						</div>
					</div>
					<div class = "row">
						<div class = "medium-4 columns">
							<div class="row collapse">
						        <label><img alt="facebook" src="<?php echo $program->getDir(); ?>img/web.png" width = "20px"> Web</label>
						        <div class="small-3 columns">
						          <span class="postfix">http://</span>
						        </div>
						        <div class="small-9 columns">
						          <input type="text" placeholder="Pon el enlace completo" name = "web" value = "<?php echo $info->get('web'); ?>"/>
						        </div>
						    </div>
						</div>
					</div>
					<div class = "row">
						<label>Una breve descripción sobre ti
							<textarea rows = "10" id = "ck_description" name = "description"><?php echo $info->get('description'); ?></textarea>
						</label>
					</div>
				</div>
			</fieldset>
			</div>
		</div>
		<br>
		
		<input type = "hidden" name = "enum" value = "info" />
		<div class = "medium-12 columns">
			  <button class = "button expand" type="submit">GUARDAR</button>
		  </div>
	</div>
	</form>
</div>