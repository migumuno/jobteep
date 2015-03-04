<!-- (?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$ -->
<form data-abide class="peThemeContactForm" method = "post" action = "?menu=login&action=changePass">
	<div id="personal" class="bay form-horizontal">
		<?php 
		if (SO::$ALERT) {
			echo '<div data-alert class="alert-box info radius">
				'.SO::$MESSAGE.'
			  <a href="#" class="close">&times;</a>
			</div>';
		}
		?>
	  <div class="password-field control-group">
	  	<div class = "control">
	  		<input class="span9" type="password" name="pass" value="Contraseña" onclick="if(this.value=='Contraseña') this.value=''" onblur="if(this.value=='') this.value='Contraseña'" id="pass" required pattern=".{6,}">
		    <small class="error">La contraseña debe tener un mínimo de 6 caracteres.</small>
		</div>
	  </div>
	  <div class="password-field control-group">
	  	<div class = "control">
	  		<input class="span9" type="password" name="pass2" value="Contraseña" onclick="if(this.value=='Contraseña') this.value=''" onblur="if(this.value=='') this.value='Contraseña'" id="pass2" pattern=".{6,}" data-equalto="pass">
		    <small class="error">Las contraseñas no coinciden.</small>
		</div>
	  </div>
	  <input type = "hidden" name = "key" value = "<?php echo $_GET['key'] ?>">
	   <div class="control-group">
		<div class="controls send-btn">
			<button type="submit" class="contour-btn red">Cambiar</button>
		</div>
	  </div>
	  <h4></h4>
	</div>
</form>
<small>Ya me acuerdo, <a href = "?menu=login">entrar.</a></small><br>
<small>Equipo de soporte <a href = "mailto:help@jobteep.com">help@jobteep.com</a></small>