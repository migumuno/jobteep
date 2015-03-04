<?php
//Probablemente no se necesite el UID ya que está dentro de una carpeta propia del usuario.
//El dir sera el user, que es el nombre de la carpeta.
$_SESSION['imagePicker'] = $_SESSION['SO']->getUserInfo ('dir');
$_SESSION['nameImg'] = 'info';

$controller = $_SESSION['SO']->getController();
$controller->setEnum('info');
$url = $controller->getUrlFbk('intro');

$fbk = array(
		"first_name" => null,
		"last_name" => null,
		"birthday" => null,
		"id" => null
);
if (isset($_GET['action']) && $_GET['action'] == "facebook") {
	if ($controller->getFbkId() != 0) {
		$fbk = $controller->getFacebook();
	}
}
if (isset($fbk) && isset($fbk['id'])) {
	$img_profile = 'http://graph.facebook.com/'.$fbk['id'].'/picture?width=300&height=300';
	$img_include = 'facebook';
} else {
	$img_profile = $program->getDir().'img/profile.png';
	$img_include = null;
}
?>
<div id="modalLinkedin" class="reveal-modal" data-reveal>
  <h2>Linkedin</h2>
  <p class="lead">Necesitamos que te conectes a tu cuenta de Linkedin para copiar los datos a tu perfil.</p>
  <script type="IN/Login" data-onAuth="onAuthLinkedin"></script>
</div>
<div class = "panel">
	<!-- Conexión con Linkedin -->
	<div class = "row text-center">
		<span class = "iconos_redes"><a href = "#"><img onclick = "instertData()" alt="linkedin" src="<?php echo $program->getDir() . "/img/logo_linkedin.png" ?>" width = "100px"></a></span>
	</div>
	<div class = "row text-center">
		<p><img alt="cargar datos linkedin" src="Programs/Panel/img/question.png" width = "20px"> <small>Podemos cargar tus datos desde Linkedin para que te sea más fácil.</small></p>
	</div>
	<!-- Formulario -->
	<form name = "Intro" data-abide method = "post" action = "#" enctype="multipart/form-data">
		<fieldset>
			<legend>Información Personal</legend>
			<div class = "row">
				<div class = "medium-4 padding_left columns">
					<div class = "row">
						<img src="<?php echo $img_profile; ?>" id="avatar" width = "100%">
					</div>
					<div class = "row">
						<a href="#" data-ip-modal="#avatarModal" class="button expand">SUBIR FOTO</a>
						<input type = "hidden" name = "img" value = "<?php echo $img_include; ?>" id = "perfil">
					</div>
				</div>
				<div class = "medium-8 columns">
					<div class = "medium-6 columns">
						<div class = "row">
							<div class = "name-field">
								<label>Nombre <small>Requerido</small>
									<input type = "text" name = "name" value = "<?php echo $fbk['first_name'] ?>" required>
								</label>
								<small class="error" id = "nameError">Necesitamos saber tu nombre.</small>
							</div>
						</div>
						<div class = "row">
							<label>Apellidos <small>Requerido</small>
								<input type = "text" name = "surname" value = "<?php echo $fbk['last_name'] ?>" required>
							</label>
							<small class="error" id = "surnameError">Necesitamos saber tus apellidos.</small>
						</div>
						<div class = "row">
							<div class = "surname-field">
								<label>Fecha nacimiento <small>Requerido</small>
									<input type = "date" name = "birthday" id = "birthday" placeholder="aaaa/mm/dd" value = "<?php if (isset($fbk['birthday'])) echo date('Y/m/d', strtotime($fbk['birthday'])) ?>" required pattern="^(19|20)\d\d[- /.](0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])$"/>
								</label>
								<small class="error" id = "dateError">Necesitamos una fecha correcta, a las empresas les gustará saber tu edad.</small>
							</div>
						</div>
						<div class = "row">
							<div class = "language-field">
								<label>Idioma nativo <small>Requerido</small>
									<input type = "text" list = "languages" name = "native_language" placeholder="El nombre de tu idioma nativo" required/>
								</label>
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
								<small class="error" id = "languageError">Necesitamos saber tus idioma.</small>
							</div>
						</div>
						<div class = "row">
							<div class = "email-field">
								<label>Email público <span data-tooltip class="has-tip" title="Este email aparecerá en tu perfil de forma pública."><img alt="The Jobfeel" src="Programs/Panel/img/question.png" width = "20px"></span>
									<input type = "email" name = "email" id = "email" placeholder="email@email.com"/>
								</label>
							</div>
						</div>
					</div>
					<div class = "medium-6 columns">
						<div class = "row">
							<div class = "telf-field">
								<label>Teléfono
									<input type = "tel" name = "telf1" placeholder="555555555"/>
								</label>
							</div>
						</div>
						<div class = "row">
							<div class = "domain-field">
								<label>Elige tu dominio <span id = "domain_error"></span> <span data-tooltip class="has-tip" title="El dominio es la dirección de tu perfil: www.jobteep.com/dominio"><img alt="The Jobfeel" src="Programs/Panel/img/question.png" width = "20px"></span> <small>requerido</small>
									<input type = "text" name = "domain" id = "domain" placeholder="El nombre de tu página" pattern="^[a-z0-9_]*$" required />
								</label>
								<small class="error" id = "domainError">Necesitamos saber el dominio para que puedan ver tu curriculum. Están permitidas letras minúsculas sin acento, números y _</small>
							</div>
						</div>
						<div class = "row">
							<div class = "looking-field">
								<label>¿Qué estas buscando?
									<select name = "lookingfor">
						  				<?php 
						  				$lookingfor = array("Nada", "Prácticas", "Beca", "Formación", "Primer empleo", "Trabajo", "Voluntariado", "Inversión", "Apoyo");
						  				for ($i = 0; $i < count($lookingfor); $i++) {
											echo '<option value = "'.$i.'">'.$lookingfor[$i].'</option>';
										}
						  				?>
						  			</select>
								</label>
							</div>
						</div>
						<div class = "row">
							<div class = "profession-field">
								<label>En dos palabras <small>Importante</small>
									<input id = "profession" type = "text" name = "profession" placeholder = "Descríbete en dos o tres palabras" id = "profession" />
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class = "row">
				<div class = "medium-12 columns">
					<div class = "slogan-field">
						<label>Un Eslogan <small>Importante</small>
					        <input id = "slogan" type = "text" name = "slogan" placeholder="Añade un slogan con el que te sientas identificado." />
					    </label>
				    </div>
				</div>
			</div>
		</fieldset><br>
		<fieldset>
			<legend>Localización <span data-tooltip class="has-tip" title="Podemos detectar tu ubicación para ayudarte a rellenar los campos, pincha en Encuéntrame"><img alt="The Jobfeel" src="Programs/Panel/img/question.png" width = "20px"></span> <small><a href="#map" class="google" >Encuéntrame</a></small></legend>
			<div class = "row">
				<div class = "medium-12 columns">
					<div class = "medium-6 columns">
						<div class = "row">
							<div class = "city-field">
								<label>Ciudad <small>requerido</small>
						        	<input type = "text" name = "city" id = "city" required/>
						      	</label>
						     	<small class="error" id = "cityError">A las empresas les gustará saber de donde eres.</small>
						     </div>
					     </div>
					</div>
					<div class = "medium-6 columns">
						<div class = "row">
							<div class = "country-field">
								<label>País <small>requerido</small>
						        	<input type = "text" name = "country" id = "country" required/>
						      	</label>
						      	<small class="error" id = "countryError">A las empresas les gustará saber de donde eres.</small>
						    </div>
						</div>
					</div>
				</div>
			</div>
		</fieldset><br>
		<fieldset>
			<legend>Elige los sectores con los que te identificas en orden de preferencia.</legend>
			<div class = "row">
				<div class = "medium-12 columns">
					<?php 
					$sector_fields = array("Sector primario", "Sector secundario", "Sector terciario");
					$sector_fields2 = array("sectorprimario", "sectorsecundario", "sectorterciario");
					for ($i = 0; $i < count($sector_fields); $i++) {
						$sector = $i + 1;
						echo '
						<div class = "medium-4 columns">
							<div class = "'.$sector_fields2[$i].'-field">
								<label>'.$sector_fields[$i].'
									<select name = "sector'.$sector.'">
						  				<option value = "none">...</option>';
							        	$result = $controller->getData('sector');
							        	for($j = 0; $j < $result->num_rows; $j++) {
											$result->data_seek($j);
											$row = $result->fetch_assoc();
											echo '<option value = "'.$row['id_sector'].'">'.$row['name'].'</option>';
										}
							echo '
				  					</select>
								</label>
							</div>
						</div>
						';
					}
					?>
				</div>
			</div>
		</fieldset><br>
		<div id = "linkedin_id"></div>
		<div class = "hidden-field"><input type = "hidden" name = "id_lnkdn" value = ""></div>
		<div class = "hidden-field"><input type = "hidden" name = "description" value = ""></div>
		<div class = "hidden-field"><input type = "hidden" name = "enum" value = "info"></div>
	 	<button class = "button expand" type="submit">COMENZAR</button>
	</form>
</div>